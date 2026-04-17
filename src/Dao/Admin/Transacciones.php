<?php

namespace Dao\Admin;

use Dao\Table;

class Transacciones extends Table
{
    public static function getTransacciones()
{
    $sqlstr = "SELECT t.id, t.usercod, u.username, u.useremail,
               t.monto, t.fecha, t.tipo, t.referencia, t.estado
               FROM transacciones t
               INNER JOIN usuario u ON t.usercod = u.usercod
               ORDER BY t.fecha DESC";
    return self::obtenerRegistros($sqlstr, []);
}

public static function getTransaccionById(int $id)
{
    $sqlstr = "SELECT t.id, t.usercod, u.username, u.useremail,
               t.monto, t.fecha, t.tipo, t.referencia, t.estado
               FROM transacciones t
               INNER JOIN usuario u ON t.usercod = u.usercod
               WHERE t.id = :id";
    return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
}

    public static function insertTransaccion(int $usercod, float $monto, string $tipo, $referencia, string $estado)
    {
        $sqlstr = "INSERT INTO transacciones (usercod, monto, fecha, tipo, referencia, estado)
                   VALUES (:usercod, :monto, NOW(), :tipo, :referencia, :estado)";
        return self::executeNonQuery($sqlstr, [
            "usercod"    => $usercod,
            "monto"      => $monto,
            "tipo"       => $tipo,
            "referencia" => $referencia,
            "estado"     => $estado
        ]);
    }

    public static function deleteTransaccion(int $id)
    {
        $sqlstr = "DELETE FROM transacciones WHERE id = :id";
        return self::executeNonQuery($sqlstr, ["id" => $id]);
    }
}
?>