<?php

namespace Controllers\Services;

use Controllers\PrivateController;
use Dao\Services\Services as DaoServices;
use Views\Renderer;

class Services extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        $services = DaoServices::getServices();

        foreach ($services as &$service) {
            $service["statusDsc"] = $service["estado"] === "ACT" ? "Activo" : "Inactivo";
        }

        $this->viewData = [
            "services" => $services,
            "showNew" => $this->isFeatureAutorized("services_listado_INS"),
            "showUpdate" => $this->isFeatureAutorized("services_listado_UPD"),
            "showDelete" => $this->isFeatureAutorized("services_listado_DEL"),
            "showActions" => (
                $this->isFeatureAutorized("services_listado_UPD") ||
                $this->isFeatureAutorized("services_listado_DEL")
            )
        ];

        Renderer::render("services/services", $this->viewData);
    }
}
