<?php

namespace Controllers\Citas;

use Controllers\PrivateController;
use Dao\Citas\Citas as DaoCitas;
use Views\Renderer;

const LIST_VIEW_TEMPLATE = "citas/citas";
class Citas extends PrivateController
{
    private array $citasList = [];

    public function run(): void
    {
        $this->citasList = DaoCitas::getCitas();

        foreach ($this->citasList as &$cita) {
            if ($cita["estado"] === "pendiente") {
                $cita["estadoDsc"] = "Pendiente";
            } elseif ($cita["estado"] === "confirmada") {
                $cita["estadoDsc"] = "Confirmada";
            } elseif ($cita["estado"] === "cancelada") {
                $cita["estadoDsc"] = "Cancelada";
            } else {
                $cita["estadoDsc"] = $cita["estado"];
            }
        }

        Renderer::render(LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "citas" => $this->citasList,
            "showNew" => $this->isFeatureAutorized("citas_listado_INS"),
            "showUpdate" => $this->isFeatureAutorized("citas_listado_UPD"),
            "showDelete" => $this->isFeatureAutorized("citas_listado_DEL"),
            "showActions" => (
                $this->isFeatureAutorized("citas_listado_UPD") ||
                $this->isFeatureAutorized("citas_listado_DEL")
            )
        ];
    }
}
