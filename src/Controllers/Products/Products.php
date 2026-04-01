<?php

namespace Controllers\Products;

use Controllers\PrivateController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Products\Products as DaoProducts;
use Views\Renderer;

class Products extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        $products = DaoProducts::getProducts();

        foreach ($products as &$product) {
            $product["productStatusDsc"] = $product["productStatus"] === "ACT" ? "Activo" : "Inactivo";
        }

        $this->viewData = [
            "products" => $products,
            "showNew" => $this->isFeatureAutorized("productos_listado_INS"),
            "showUpdate" => $this->isFeatureAutorized("productos_listado_UPD"),
            "showDelete" => $this->isFeatureAutorized("productos_listado_DEL"),
            "showActions" => (
                $this->isFeatureAutorized("productos_listado_UPD") ||
                $this->isFeatureAutorized("productos_listado_DEL")
            )
        ];

        Renderer::render("products/products", $this->viewData);
    }
}
