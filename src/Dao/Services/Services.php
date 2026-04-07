<?php

namespace Dao\Services;

use Dao\Table;

class Services extends Table
{
    public static function getServices()
    {
        $sqlstr = "SELECT servicio_id, nombre, descripcion, precio, estado FROM servicios ORDER BY servicio_id DESC";
        $params = [];
        return self::obtenerRegistros($sqlstr, $params);
    }

    public static function getServiceById(int $servicio_id)
    {
        $sqlstr = "SELECT servicio_id, nombre, descripcion, precio, estado FROM servicios WHERE servicio_id = :servicio_id";
        $params = ["servicio_id" => $servicio_id];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertService(string $nombre, string $descripcion, float $precio, string $estado)
    {
        $sqlstr = "INSERT INTO servicios (nombre, descripcion, precio, estado) VALUES
                    (:nombre, :descripcion, :precio, :estado)";
        $params = [
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "estado" => $estado
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateService(int $servicio_id, string $nombre, string $descripcion, float $precio, string $estado)
    {
        $sqlstr = "UPDATE servicios
                   SET nombre = :nombre,
                       descripcion = :descripcion,
                       precio = :precio,
                       estado = :estado
                   WHERE servicio_id = :servicio_id";
        $params = [
            "servicio_id" => $servicio_id,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "estado" => $estado
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteService(int $servicio_id)
    {
        $sqlstr = "DELETE FROM servicios WHERE servicio_id = :servicio_id";
        $params = ["servicio_id" => $servicio_id];
        return self::executeNonQuery($sqlstr, $params);
    }
}
