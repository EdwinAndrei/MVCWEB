<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Accept extends PublicController
{
    public function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $dataview = array();
        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["orderid"] ?? "";

        if ($token !== "" && $token == $session_token) {

            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );

            // Capturar solo si es una orden nueva
            if (
                !isset($_SESSION["last_captured_token"]) ||
                $_SESSION["last_captured_token"] !== $token
            ) {
                $result = $PayPalRestApi->captureOrder($session_token);

                $_SESSION["paypal_result"] = $result;
                $_SESSION["last_captured_token"] = $token;
            } else {
                // reutilizar resultado ya capturado
                $result = $_SESSION["paypal_result"];
            }

            // Si el pago fue exitoso
            if ($result && ($result->status ?? "") === "COMPLETED") {

                $usercod = \Utilities\Security::getUserId();
                \Dao\Carretilla\Carretilla::clearCart($usercod);

                 // Calcular monto desde respuesta PayPal
                $monto = 0;
                $captures = $result->purchase_units[0]->payments->captures ?? [];
                if (!empty($captures)) {
                $monto = floatval($captures[0]->amount->value);
                 }

                  // Guardar transacción en BD
                 \Dao\Admin\Transacciones::insertTransaccion(
                $usercod,
                $monto,
                'producto',
                $session_token,
                'completado'
                );

                $resultDelete = \Dao\Carretilla\Carretilla::clearCart($usercod);
                // Mapear datos para la factura
                $dataview["orderId"] = $result->id ?? "";
                $dataview["fecha"] = $result->purchase_units[0]->payments->captures[0]->create_time ?? "";

                $dataview["captureId"] = $result->purchase_units[0]->payments->captures[0]->id ?? "";
                $dataview["monto"] = $result->purchase_units[0]->payments->captures[0]->amount->value ?? "";
                $dataview["moneda"] = $result->purchase_units[0]->payments->captures[0]->amount->currency_code ?? "";

                // Referencia interna
                $dataview["referenceId"] = $result->purchase_units[0]->reference_id ?? "";

                // Cliente REAL desde PayPal
                $dataview["paypalNombre"] =
                    ($result->payer->name->given_name ?? "") . " " .
                    ($result->payer->name->surname ?? "");

                $dataview["paypalEmail"] = $result->payer->email_address ?? "";
                $dataview["payerId"] = $result->payer->payer_id ?? "";

                // Dirección de envío
                $shipping = $result->purchase_units[0]->shipping ?? null;

                $dataview["direccion"] = $shipping->address->address_line_1 ?? "";
                $dataview["ciudad"] = $shipping->address->admin_area_2 ?? "";
                $dataview["region"] = $shipping->address->admin_area_1 ?? "";
                $dataview["postal"] = $shipping->address->postal_code ?? "";

                // Desglose de pago
                $breakdown = $result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown ?? null;

                $dataview["bruto"] = $breakdown->gross_amount->value ?? "";
                $dataview["fee"] = $breakdown->paypal_fee->value ?? "";
                $dataview["neto"] = $breakdown->net_amount->value ?? "";

                // Protección del vendedor
                $dataview["proteccion"] =
                    $result->purchase_units[0]->payments->captures[0]->seller_protection->status ?? "";
            }

            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }

        // Datos del usuario
        $user = \Utilities\Security::getUser();

        $dataview["clienteNombre"] = $user["userName"] ?? "Invitado";
        $dataview["clienteEmail"]  = $user["userEmail"] ?? "N/A";
        $dataview["clientePais"] = "HN";

        \Views\Renderer::render("paypal/accept", $dataview);
    }
}