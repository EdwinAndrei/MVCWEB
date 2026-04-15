<?php
// CRUD. (Create, Read, Update Delete)
//       ( Insert, Select, Update, Delete)
//       ( INS, DSP, UPD, DEL)

namespace Controllers\Historial\Citas;

use Controllers\PublicController;
use Views\Renderer;

use Dao\Historial\Citas as CitasDAO;

const CITAS_LIST_VIEW_TEMPLATE = "historial/citas/listado";

class Listado extends PublicController
{

    private array $citasList = [];

    public function run(): void
    {
        $this->citasList = CitasDAO::getAllCitas();
        Renderer::render(CITAS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "citas" => $this->citasList
        ];
    }
}
