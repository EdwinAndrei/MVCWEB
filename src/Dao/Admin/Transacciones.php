<?php

namespace Dao\Admin;

use Dao\Table;

class Transacciones extends Table
{
    public static function getTransacciones()
{
    $sqlstr = "SELECT p.id, p.usercod, u.username, u.useremail,
               p.monto, p.fecha, p.tipo, p.referencia
               FROM pagos p
               INNER JOIN usuario u ON p.usercod = u.usercod
               ORDER BY p.fecha DESC";
    return self::obtenerRegistros($sqlstr, []);
}

public static function getTransaccionById(int $id)
{
    $sqlstr = "SELECT p.id, p.usercod, u.username, u.useremail,
               p.monto, p.fecha, p.tipo, p.referencia
               FROM pagos p
               INNER JOIN usuario u ON p.usercod = u.usercod
               WHERE p.id = :id";
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