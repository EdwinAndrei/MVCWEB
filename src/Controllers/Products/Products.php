<?php

namespace Controllers\Products;

use Controllers\PrivateController;
use Dao\Products\Products as DaoProducts;
use Views\Renderer;
use Utilities\Security;

const LIST_VIEW_TEMPLATE = "products/products";

class Products extends PrivateController
{
    private array $productsList = [];

    public function run(): void
    {
        $usercod = Security::getUserId();
        if (Security::isInRol($usercod, "USER")) {
            $this->productsList = DaoProducts::getActiveProducts();
        } else {
            $this->productsList = DaoProducts::getProducts();
        }

        foreach ($this->productsList as &$product) {
            if ($product["productStatus"] === "ACT") {
                $product["productStatusDsc"] = "Activo";
                $product["permitirCarrito"] = true;
            } else {
                $product["productStatusDsc"] = "Inactivo";
                $product["permitirCarrito"] = false;
            }
        }

        Renderer::render(LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "products" => $this->productsList,
            "showNew" => $this->isFeatureAutorized("productos_listado_INS"),
            "showUpdate" => $this->isFeatureAutorized("productos_listado_UPD"),
            "showDelete" => $this->isFeatureAutorized("productos_listado_DEL"),
            "showActions" => (
                $this->isFeatureAutorized("productos_listado_UPD") ||
                $this->isFeatureAutorized("productos_listado_DEL")
            ),
            "showCartActions" => (
                $this->isFeatureAutorized("carretilla_add")
            )
        ];
    }
}