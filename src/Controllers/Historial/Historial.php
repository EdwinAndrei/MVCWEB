<?php
namespace Controllers\Historial;

use Controllers\PrivateController;
use Views\Renderer;

class Historial extends PrivateController
{
    public function run(): void
    {
        $data = \Dao\Table::obtenerRegistros(
            "SELECT h.*, u.username 
             FROM historial h 
             INNER JOIN usuario u ON h.usercod = u.usercod
             ORDER BY fecha DESC",
            []
        );

        Renderer::render("historial/historial", ["historial" => $data]);
    }
}