<?php

namespace Controllers\Services;

use Controllers\PrivateController;
use Dao\Services\Services as DaoServices;
use Views\Renderer;

const LIST_VIEW_TEMPLATE = "services/services";

class Services extends PrivateController
{
    private array $servicesList = [];

    public function run(): void
    {
        $this->servicesList = DaoServices::getServices();

        foreach ($this->servicesList as &$service) {
            if ($service["estado"] === "ACT") {
                $service["statusDsc"] = "Activo";
            } else {
                $service["statusDsc"] = "Inactivo";
            }
        }

        Renderer::render(LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "services" => $this->servicesList,
            "showNew" => $this->isFeatureAutorized("services_listado_INS"),
            "showUpdate" => $this->isFeatureAutorized("services_listado_UPD"),
            "showDelete" => $this->isFeatureAutorized("services_listado_DEL"),
            "showActions" => (
                $this->isFeatureAutorized("services_listado_UPD") ||
                $this->isFeatureAutorized("services_listado_DEL")
            )
        ];
    }
}
