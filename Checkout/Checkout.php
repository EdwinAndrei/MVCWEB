<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Checkout extends PublicController
{
    public function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $viewData = array();

        if ($this->isPostBack()) {

            $usercod = $_SESSION["usercod"] ?? 1;

            // Obtener carrito
            $items = \Dao\Carretilla\Carretilla::getItemsByUser($usercod);

            if (empty($items)) {
                echo "Carrito vacío";
                die();
            }

            // Crear orden PayPal
            $PayPalOrder = new \Utilities\Paypal\PayPalOrder(
                "ORDER-" . time(),
                "http://localhost:8080/PedroNegocioWEB/index.php?page=Checkout_Error",
                "http://localhost:8080/PedroNegocioWEB/index.php?page=Checkout_Accept"
            );

            // Agregar productos dinámicamente
            foreach ($items as $item) {
                $PayPalOrder->addItem(
                    $item["productName"],
                    $item["productName"],
                    $item["productId"],
                    floatval($item["precio"]),
                    0,
                    intval($item["cantidad"]),
                    "PHYSICAL_GOODS"
                );
            }

            // API PayPal
            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );

            $PayPalRestApi->getAccessToken();
            $response = $PayPalRestApi->createOrder($PayPalOrder);

            // Validar respuesta
            if (!isset($response->id)) {
                echo "Error al crear la orden en PayPal";
                die();
            }

            $_SESSION["orderid"] = $response->id;

            foreach ($response->links as $link) {
                if ($link->rel == "approve") {
                    \Utilities\Site::redirectTo($link->href);
                }
            }

            echo "No se encontró enlace de aprobación";
            die();
        }

        // echo "LLEGÓ AL CHECKOUT";
        // die();

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}
