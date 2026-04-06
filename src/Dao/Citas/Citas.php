<?php

namespace Dao\Citas;

use Dao\Table;

class Citas extends Table
{
    public static function getCitas()
    {
        $sqlstr = "SELECT c.id, c.usercod, c.servicio_id, c.fecha, c.hora, c.estado, s.nombre AS servicio_nombre, u.username FROM citas c INNER JOIN servicios s ON c.servicio_id = s.servicio_id
                 INNER JOIN usuario u ON c.usercod = u.usercod";
        $params = [];
        return self::obtenerRegistros($sqlstr, $params);
    }

    public static function getCitaById(int $id)
    {
        $sqlstr = "SELECT c.id, c.usercod, c.servicio_id, c.fecha, c.hora, c.estado, u.username FROM citas c INNER JOIN usuario u ON c.usercod = u.usercod WHERE id = :id";
        $params = ["id" => $id];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertCita(int $usercod, int $servicio_id, string $fecha, string $hora, string $estado)
    {
        $sqlstr = "INSERT INTO citas (usercod, servicio_id, fecha, hora, estado)
                   VALUES (:usercod, :servicio_id, :fecha, :hora, :estado)";
        $params = [
            "usercod" => $usercod,
            "servicio_id" => $servicio_id,
            "fecha" => $fecha,
            "hora" => $hora,
            "estado" => $estado
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateCita(int $id, int $usercod, int $servicio_id, string $fecha, string $hora, string $estado)
    {
        $sqlstr = "UPDATE citas SET usercod = :usercod, servicio_id = :servicio_id, fecha = :fecha, hora = :hora, estado = :estado WHERE id = :id";
        $params = [
            "id" => $id,
            "usercod" => $usercod,
            "servicio_id" => $servicio_id,
            "fecha" => $fecha,
            "hora" => $hora,
            "estado" => $estado
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteCita(int $id)
    {
        $sqlstr = "DELETE FROM citas WHERE id = :id";
        $params = ["id" => $id];
        return self::executeNonQuery($sqlstr, $params);
    }
}
