<?php

namespace Dao\Admin;

use Dao\Table;

class Logs extends Table
{
    public static function getLogs()
    {
        $sqlstr = "SELECT l.id, l.usercod, u.username, l.accion, l.fecha
                   FROM logs l
                   INNER JOIN usuario u ON l.usercod = u.usercod
                   ORDER BY l.fecha DESC";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function registrar(int $usercod, string $accion)
    {
        $sqlstr = "INSERT INTO logs (usercod, accion, fecha)
                   VALUES (:usercod, :accion, NOW())";
        return self::executeNonQuery($sqlstr, [
            "usercod" => $usercod,
            "accion"  => $accion
        ]);
    }
}
?>