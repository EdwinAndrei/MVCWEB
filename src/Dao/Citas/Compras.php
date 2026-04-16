<?php

namespace Dao\Historial;

use Dao\Table;

class Compras extends Table
{
    /*
    compras
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usercod BIGINT(10) NOT NULL,
    fecha DATETIME NOT NULL,
    total DECIMAL(10,2) NOT NULL

    detalle_compra
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    compra_id INT NOT NULL,
    productId INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
    */

    public static function getAllCompras(): array
    {
        $sqlstr = "SELECT c.id, c.usercod, u.username, c.fecha, c.total
                   FROM compras c
                   INNER JOIN usuario u ON c.usercod = u.usercod
                   ORDER BY c.fecha DESC;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getCompraById(int $id): array
    {
        $sqlstr = "SELECT c.id, c.usercod, u.username, c.fecha, c.total
                   FROM compras c
                   INNER JOIN usuario u ON c.usercod = u.usercod
                   WHERE c.id = :id;";
        $param = ["id" => $id];
        return self::obtenerUnRegistro($sqlstr, $param);
    }

    public static function getDetalleByCompraId(int $compra_id): array
    {
        $sqlstr = "SELECT dc.id, dc.compra_id, dc.productId, p.productName, dc.cantidad, dc.precio,
                          (dc.cantidad * dc.precio) AS subtotal
                   FROM detalle_compra dc
                   INNER JOIN products p ON dc.productId = p.productId
                   WHERE dc.compra_id = :compra_id;";
        $param = ["compra_id" => $compra_id];
        return self::obtenerRegistros($sqlstr, $param);
    }
}

