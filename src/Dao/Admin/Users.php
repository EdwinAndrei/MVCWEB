<?php

namespace Dao\Admin;

use Dao\Table;

class Users extends Table
{
    public static function getUsuarios()
    {
        $sqlstr = "SELECT u.usercod, u.useremail, u.username, u.userest,
                   GROUP_CONCAT(ru.rolescod SEPARATOR ', ') as roles
                   FROM usuario u
                   LEFT JOIN roles_usuarios ru ON u.usercod = ru.usercod AND ru.roleuserest = 'ACT'
                   GROUP BY u.usercod
                   ORDER BY u.usercod ASC";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getUsuarioById(int $usercod)
    {
        $sqlstr = "SELECT usercod, useremail, username, userest
                   FROM usuario WHERE usercod = :usercod";
        return self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
    }

    public static function getRoles()
    {
        $sqlstr = "SELECT rolescod, rolesdsc FROM roles WHERE rolesest = 'ACT'";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getRolesByUsuario(int $usercod)
    {
        $sqlstr = "SELECT rolescod FROM roles_usuarios
                   WHERE usercod = :usercod AND roleuserest = 'ACT'";
        return self::obtenerRegistros($sqlstr, ["usercod" => $usercod]);
    }

    public static function updateUsuario(int $usercod, string $username, string $useremail, string $userest)
    {
        $sqlstr = "UPDATE usuario SET username = :username, useremail = :useremail,
                   userest = :userest WHERE usercod = :usercod";
        return self::executeNonQuery($sqlstr, [
            "usercod"   => $usercod,
            "username"  => $username,
            "useremail" => $useremail,
            "userest"   => $userest
        ]);
    }

    public static function deleteUsuario(int $usercod)
    {
        $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod";
        return self::executeNonQuery($sqlstr, ["usercod" => $usercod]);
    }

    public static function asignarRol(int $usercod, string $rolescod)
    {
        $sqlstr = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch)
                   VALUES (:usercod, :rolescod, 'ACT', NOW())
                   ON DUPLICATE KEY UPDATE roleuserest = 'ACT', roleuserfch = NOW()";
        return self::executeNonQuery($sqlstr, [
            "usercod"  => $usercod,
            "rolescod" => $rolescod
        ]);
    }

    public static function quitarRol(int $usercod, string $rolescod)
    {
        $sqlstr = "UPDATE roles_usuarios SET roleuserest = 'INA'
                   WHERE usercod = :usercod AND rolescod = :rolescod";
        return self::executeNonQuery($sqlstr, [
            "usercod"  => $usercod,
            "rolescod" => $rolescod
        ]);
    }
}
?>