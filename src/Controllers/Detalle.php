<?php

namespace Controllers\Historial\Compras;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;

use Dao\Historial\Compras as ComprasDAO;

const COMPRAS_DETALLE_VIEW_TEMPLATE = "historial/compras/detalle";
const COMPRAS_LISTADO_URL           = "index.php?page=Historial_Compras_Listado";

class Detalle extends PublicController
{

    private array $viewData = [];

    private $id;
    private array $compra   = [];
    private array $detalle  = [];

    public function run(): void
    {
        $this->LoadPage();
        $this->GenerarViewData();
        Renderer::render(COMPRAS_DETALLE_VIEW_TEMPLATE, $this->viewData);
    }

    private function LoadPage()
    {
        $this->id = intval($_GET["id"] ?? '0');
        if ($this->id <= 0) {
            Site::redirectToWithMsg(COMPRAS_LISTADO_URL, "Error al cargar el detalle, Se requiere Id de la Compra");
        }
        $this->compra = ComprasDAO::getCompraById($this->id);
        if (count($this->compra) <= 0) {
            Site::redirectToWithMsg(COMPRAS_LISTADO_URL, "No se encontró la Compra");
        }
        $this->detalle = ComprasDAO::getDetalleByCompraId($this->id);
    }

    private function GenerarViewData()
    {
        $this->viewData["id"]       = $this->compra["id"];
        $this->viewData["usercod"]  = $this->compra["usercod"];
        $this->viewData["username"] = $this->compra["username"];
        $this->viewData["fecha"]    = $this->compra["fecha"];
        $this->viewData["total"]    = $this->compra["total"];
        $this->viewData["detalle"]  = $this->detalle;
    }
}
