<?php

namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Transacciones as DaoTransacciones;
use Views\Renderer;

class Transaccion extends PrivateController
{
    public function run(): void
    {
        $mode = \Utilities\Context::getContextByKey("mode") ?? "DSP";
        $id   = intval(\Utilities\Context::getContextByKey("id") ?? 0);

        $transaccion = [];

        if ($id > 0) {
            $transaccion = DaoTransacciones::getTransaccionById($id);
        }

        if ($this->isPostBack() && $mode === "DEL") {
            DaoTransacciones::deleteTransaccion($id);
            \Utilities\Site::redirectTo("index.php?page=Admin_Transacciones");
            return;
        }

        $viewData = array_merge($transaccion ?: [], [
            "mode"         => $mode,
            "modeDsc"      => $mode === "DEL" ? "Eliminar Transacción" : "Detalle Transacción",
            "hideConfirm"  => $mode === "DSP",
            "confirmToolTip" => "Eliminar",
            "xsrf_token"   => ""
        ]);

        Renderer::render("admin/transaccion", $viewData);
    }
}
?>