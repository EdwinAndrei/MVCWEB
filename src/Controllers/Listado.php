<?php
// CRUD. (Create, Read, Update Delete)
//       ( Insert, Select, Update, Delete)
//       ( INS, DSP, UPD, DEL)

namespace Controllers\Historial\Compras;

use Controllers\PublicController;
use Views\Renderer;

use Dao\Historial\Compras as ComprasDAO;

const COMPRAS_LIST_VIEW_TEMPLATE = "historial/compras/listado";

class Listado extends PublicController
{

    private array $comprasList = [];

    public function run(): void
    {
        $this->comprasList = ComprasDAO::getAllCompras();
        Renderer::render(COMPRAS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "compras"     => $this->comprasList,
            "showDetalle" => true
        ];
    }
}
