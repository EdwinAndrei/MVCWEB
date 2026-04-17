<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;

class Checkout extends PrivateController
{
    public function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $viewData = [];

        if ($this->isPostBack()) {

            $usercod = $_SESSION["login"]["userId"] ?? null;

            if ($usercod === null) {
                \Utilities\Site::redirectTo("index.php?page=Sec_Login");
                return;
            }

            $items = \Dao\Carretilla\Carretilla::getItemsByUser($usercod);

            if (empty($items)) {
                echo "Carrito vacío";
                die();
            }

            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? "https" : "http")
                . "://" . $_SERVER['HTTP_HOST'];

            $projectPath = dirname($_SERVER['SCRIPT_NAME']);

            $PayPalOrder = new \Utilities\Paypal\PayPalOrder(
                "ORDER-" . time(),
                $baseUrl . $projectPath . "/index.php?page=Checkout_Error",
                $baseUrl . $projectPath . "/index.php?page=Checkout_Accept"
            );

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

            $PayPalRestApi = new \Utilities\PayPal\PayPalRestApi(
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_ID"),
                \Utilities\Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );

            $PayPalRestApi->getAccessToken();
            $response = $PayPalRestApi->createOrder($PayPalOrder);

            if (!isset($response->id)) {
                echo "Error al crear la orden en PayPal";
                die();
            }

            $_SESSION["orderid"] = $response->id;

            foreach ($response->links as $link) {
                if ($link->rel === "approve") {
                    \Utilities\Site::redirectTo($link->href);
                }
            }

            echo "No se encontró enlace de aprobación";
            die();
        }

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}