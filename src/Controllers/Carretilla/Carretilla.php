<?php

namespace Controllers\Carretilla;

use Controllers\PrivateController;
use Dao\Carretilla\Carretilla as CarretillaDAO;
use Views\Renderer;
use Utilities\Site;

class Carretilla extends PrivateController
{
    public function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // $usercod = $_SESSION["usercod"] ?? 1;
        $usercod = $_SESSION["login"]["userId"] ?? null;

        if ($usercod === null) {
            \Utilities\Site::redirectTo("index.php?page=Sec_Login");
            return;
        }

        //AGREGAR AL CARRITO (CON RESERVA DE STOCK)
        if ($this->isPostBack() && isset($_POST["productId"], $_POST["quantity"], $_POST["price"])) {

            $productId = intval($_POST["productId"]);
            $quantity = max(1, intval($_POST["quantity"]));
            $price = floatval($_POST["price"]);

            $product = \Dao\Products\Products::getProductById($productId);

            if (!$product) {
                echo "Producto no existe";
                die();
            }

            if ($product["productStock"] < $quantity) {
                echo "No hay suficiente stock disponible";
                die();
            }

            //BAJAR STOCK (RESERVA)
            \Dao\Products\Products::reduceStock($productId, $quantity);

            //agregar al carrito
            \Dao\Carretilla\Carretilla::addItem($usercod, $productId, $quantity, $price);

            \Utilities\Site::redirectTo("index.php?page=Carretilla_Carretilla");
            return;
        }

        //ELIMINAR ITEM (DEVOLVER STOCK)
        if (isset($_GET["remove"])) {
            $productId = intval($_GET["remove"]);

            if ($productId > 0) {

                $items = \Dao\Carretilla\Carretilla::getItemsByUser($usercod);

                foreach ($items as $item) {
                    if ($item["productId"] == $productId) {
                        \Dao\Products\Products::increaseStock($productId, $item["cantidad"]);
                    }
                }

                \Dao\Carretilla\Carretilla::removeItem($usercod, $productId);
            }

            \Utilities\Site::redirectTo("index.php?page=Carretilla_Carretilla");
            return;
        }

        //VACIAR CARRITO (DEVOLVER TODO EL STOCK)
        if (isset($_GET["clear"]) && $_GET["clear"] == "1") {

            $items = \Dao\Carretilla\Carretilla::getItemsByUser($usercod);

            foreach ($items as $item) {
                \Dao\Products\Products::increaseStock($item["productId"], $item["cantidad"]);
            }

            \Dao\Carretilla\Carretilla::clearCart($usercod);

            \Utilities\Site::redirectTo("index.php?page=Carretilla_Carretilla");
            return;
        }

        //MOSTRAR CARRITO
        $items = \Dao\Carretilla\Carretilla::getItemsByUser($usercod);
        $total = 0.0;

        foreach ($items as &$item) {
            $item["subtotal"] = floatval($item["cantidad"]) * floatval($item["precio"]);
            $total += $item["subtotal"];
        }
        unset($item);

        \Views\Renderer::render("carretilla/lista", [
            "carretilla" => $items,
            "total" => number_format($total, 2)
        ]);
    }
}
