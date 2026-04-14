<?php

namespace Dao\Historial;

use Dao\Table;

class Citas extends Table
{
    /*
    citas
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usercod BIGINT(10) NOT NULL,
    servicio_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado VARCHAR(50) NOT NULL

    servicios
    servicio_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    estado VARCHAR(50) NOT NULL
    */

    public static function getAllCitas(): array
    {
        $sqlstr = "SELECT ci.id, ci.usercod, u.username, ci.servicio_id, s.nombre AS servicio_nombre,
                          ci.fecha, ci.hora, ci.estado
                   FROM citas ci
                   INNER JOIN usuario u ON ci.usercod = u.usercod
                   INNER JOIN servicios s ON ci.servicio_id = s.servicio_id
                   ORDER BY ci.fecha DESC, ci.hora DESC;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getCitaById(int $id): array
    {
        $sqlstr = "SELECT ci.id, ci.usercod, u.username, ci.servicio_id, s.nombre AS servicio_nombre,
                          s.descripcion AS servicio_descripcion, s.precio AS servicio_precio,
                          ci.fecha, ci.hora, ci.estado
                   FROM citas ci
                   INNER JOIN usuario u ON ci.usercod = u.usercod
                   INNER JOIN servicios s ON ci.servicio_id = s.servicio_id
                   WHERE ci.id = :id;";
        $param = ["id" => $id];
        return self::obtenerUnRegistro($sqlstr, $param);
    }
}
