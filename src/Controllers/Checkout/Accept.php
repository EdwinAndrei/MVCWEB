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

            // Capturar pago
            $result = $PayPalRestApi->captureOrder($session_token);

            //limpiar carrito SOLO si todo salió bien
            if (is_object($result) && ($result->status ?? "") === "COMPLETED") {
                $usercod = $_SESSION["usercod"] ?? 1;

                //Obtener productos del carrito
                $items = \Dao\Carretilla\Carretilla::getItemsByUser($usercod);

                //Descontar stock
                foreach ($items as $item) {
                    \Dao\Products\Products::reduceStock(
                        intval($item["productId"]),
                        intval($item["cantidad"])
                    );
                }

                //Limpiar carrito
                \Dao\Carretilla\Carretilla::clearCart($usercod);
            }

            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }

        \Views\Renderer::render("paypal/accept", $dataview);
    }
}
