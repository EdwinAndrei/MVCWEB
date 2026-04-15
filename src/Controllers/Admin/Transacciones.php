<?php

namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Transacciones as DaoTransacciones;
use Views\Renderer;

const TRANS_LIST_VIEW_TEMPLATE = "admin/transacciones";

class Transacciones extends PrivateController
{
    private array $transaccionesList = [];

    public function run(): void
    {
        $this->transaccionesList = DaoTransacciones::getTransacciones();

        Renderer::render(TRANS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "transacciones"  => $this->transaccionesList,
            "showDelete"     => $this->isFeatureAutorized("transacciones_listado_DEL"),
            "showDetail"     => $this->isFeatureAutorized("transacciones_listado_DSP"),
            "showActions"    => (
                $this->isFeatureAutorized("transacciones_listado_DEL") ||
                $this->isFeatureAutorized("transacciones_listado_DSP")
            )
        ];
    }
}
?>