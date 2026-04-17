<?php

namespace Dao\Security;

use Exception;

if (version_compare(phpversion(), '7.4.0', '<')) {
    define('PASSWORD_ALGORITHM', 1);  //BCRYPT
} else {
    define('PASSWORD_ALGORITHM', '2y');  //BCRYPT
}

class Security extends \Dao\Table
{
    /* =========================
       USUARIOS
    ========================= */

    static public function getUsuarios($filter = "", $page = -1, $items = 0)
    {
        if ($filter === "" && $page === -1 && $items === 0) {
            $sqlstr = "SELECT * FROM usuario;";
        } else {
            if ($page == -1 && $items == 0) {
                $sqlstr = sprintf("SELECT * FROM usuario %s;", $filter);
            } else {
                $offset = ($page - 1) * $items;
                $sqlstr = sprintf(
                    "SELECT * FROM usuario %s LIMIT %d, %d;",
                    $filter,
                    $offset,
                    $items
                );
            }
        }
        return self::obtenerRegistros($sqlstr, []);
    }

    static public function newUsuario($email, $password, $username = "Usuario")
    {
        if (!\Utilities\Validators::IsValidEmail($email)) {
            throw new Exception("Correo no es válido");
        }

        if (!\Utilities\Validators::IsValidPassword($password)) {
            throw new Exception("Contraseña insegura");
        }

        if (trim($username) === "") {
            throw new Exception("Nombre requerido");
        }

        if (self::getUsuarioByEmail($email)) {
            throw new Exception("El correo ya está registrado");
        }

        $newUser = self::_usuarioStruct();
        $hashedPassword = self::_hashPassword($password);

        unset($newUser["usercod"]);
        unset($newUser["userfching"]);
        unset($newUser["userpswdchg"]);

        $newUser["useremail"] = $email;
        $newUser["username"] = $username;
        $newUser["userpswd"] = $hashedPassword;
        $newUser["userpswdest"] = Estados::ACTIVO;
        $newUser["userpswdexp"] = date('Y-m-d H:i:s', time() + 7776000);
        $newUser["userest"] = Estados::ACTIVO;
        $newUser["useractcod"] = hash("sha256", $email . time());
        $newUser["usertipo"] = UsuarioTipo::PUBLICO;

        $sqlIns = "INSERT INTO usuario (
            useremail, username, userpswd,
            userfching, userpswdest, userpswdexp,
            userest, useractcod, userpswdchg, usertipo
        ) VALUES (
            :useremail, :username, :userpswd,
            NOW(), :userpswdest, :userpswdexp,
            :userest, :useractcod, NOW(), :usertipo
        );";

        return self::executeNonQuery($sqlIns, $newUser);
    }

    static public function getUsuarioByEmail($email)
    {
        $sqlstr = "SELECT * FROM usuario WHERE useremail = :useremail;";
        return self::obtenerUnRegistro($sqlstr, ["useremail" => $email]);
    }

    static private function _saltPassword($password)
    {
        return hash_hmac(
            "sha256",
            $password,
            \Utilities\Context::getContextByKey("PWD_HASH")
        );
    }

    static private function _hashPassword($password)
    {
        return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
    }

    static public function verifyPassword($raw_password, $hash_password)
    {
        return password_verify(
            self::_saltPassword($raw_password),
            $hash_password
        );
    }

    static private function _usuarioStruct()
    {
        return [
            "usercod"      => "",
            "useremail"    => "",
            "username"     => "",
            "userpswd"     => "",
            "userfching"   => "",
            "userpswdest"  => "",
            "userpswdexp"  => "",
            "userest"      => "",
            "useractcod"   => "",
            "userpswdchg"  => "",
            "usertipo"     => "",
        ];
    }

    /* =========================
       ROLES Y PERMISOS (MEJORADO)
    ========================= */

    static public function getFeature($fncod)
    {
        $sqlstr = "SELECT * FROM funciones WHERE fncod = :fncod;";
        return count(self::obtenerRegistros($sqlstr, ["fncod" => $fncod])) > 0;
    }

    static public function addNewFeature($fncod, $fndsc, $fnest, $fntyp)
    {
        $sqlins = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp)
                   VALUES (:fncod, :fndsc, :fnest, :fntyp);";

        return self::executeNonQuery($sqlins, [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ]);
    }

    static public function getFeatureByUsuario($userCod, $fncod)
    {
        $sqlstr = "SELECT * FROM funciones_roles a
                   INNER JOIN roles_usuarios b ON a.rolescod = b.rolescod
                   WHERE a.fnrolest = 'ACT'
                   AND b.roleuserest = 'ACT'
                   AND b.usercod = :usercod
                   AND a.fncod = :fncod
                   LIMIT 1;";

        return count(self::obtenerRegistros($sqlstr, [
            "usercod" => $userCod,
            "fncod" => $fncod
        ])) > 0;
    }

    static public function isUsuarioInRol($userCod, $rolescod)
    {
        $sqlstr = "SELECT * FROM roles a
                   INNER JOIN roles_usuarios b ON a.rolescod = b.rolescod
                   WHERE a.rolesest = 'ACT'
                   AND b.roleuserest = 'ACT'
                   AND b.usercod = :usercod
                   AND a.rolescod = :rolescod
                   LIMIT 1;";

        return count(self::obtenerRegistros($sqlstr, [
            "usercod" => $userCod,
            "rolescod" => $rolescod
        ])) > 0;
    }

    static public function getRolesByUsuario($userCod)
    {
        $sqlstr = "SELECT * FROM roles a
                   INNER JOIN roles_usuarios b ON a.rolescod = b.rolescod
                   WHERE a.rolesest = 'ACT'
                   AND b.roleuserest = 'ACT'
                   AND b.usercod = :usercod;";

        return self::obtenerRegistros($sqlstr, ["usercod" => $userCod]);
    }

    static public function addNewRol($rolescod, $rolesdsc, $rolesest)
    {
        $sqlins = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
                   VALUES (:rolescod, :rolesdsc, :rolesest);";

        return self::executeNonQuery($sqlins, [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ]);
    }

    static public function removeRolFromUser($userCod, $rolescod)
    {
        $sqldel = "UPDATE roles_usuarios
                   SET roleuserest = 'INA'
                   WHERE rolescod = :rolescod AND usercod = :usercod;";

        return self::executeNonQuery($sqldel, [
            "rolescod" => $rolescod,
            "usercod" => $userCod
        ]);
    }

    static public function removeFeatureFromRol($fncod, $rolescod)
    {
        $sqldel = "UPDATE funciones_roles
                   SET fnrolest = 'INA'
                   WHERE fncod = :fncod AND rolescod = :rolescod;";

        return self::executeNonQuery($sqldel, [
            "fncod" => $fncod,
            "rolescod" => $rolescod
        ]);
    }

    /* =========================
       HISTORIAL Y LOGS
    ========================= */

    static public function registrarHistorial($usercod, $accion)
    {
        $sqlstr = "INSERT INTO historial (usercod, accion, fecha)
                   VALUES (:usercod, :accion, NOW());";

        return self::executeNonQuery($sqlstr, [
            "usercod" => $usercod,
            "accion" => $accion
        ]);
    }

    static public function actualizarFechaIngreso($usercod)
    {
        $sqlstr = "UPDATE usuario
                   SET userfching = NOW()
                   WHERE usercod = :usercod;";

        return self::executeNonQuery($sqlstr, [
            "usercod" => $usercod
        ]);
    }

    //Roles
    static public function getRol($rolescod)
    {
        $sqlstr = "SELECT * FROM roles WHERE rolescod = :rolescod;";
        $result = self::obtenerRegistros($sqlstr, ["rolescod" => $rolescod]);
        return count($result) > 0;
    }
    static public function asignarRolPorDefecto($usercod, $rolescod = "USER")
    {
        $sqlstr = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch)
                   VALUES (:usercod, :rolescod, 'ACT', NOW());";

        return self::executeNonQuery(
            $sqlstr,
            array(
                "usercod" => $usercod,
                "rolescod" => $rolescod
            )
        );
    }

    /* =========================
       OTROS
    ========================= */

    static public function getUnAssignedFeatures($rolescod) {}
    static public function getUnAssignedRoles($userCod) {}

    private function __construct() {}
    private function __clone() {}
}


// if (version_compare(phpversion(), '7.4.0', '<')) {
//     define('PASSWORD_ALGORITHM', 1);  // BCRYPT
// } else {
//     define('PASSWORD_ALGORITHM', '2y');  // BCRYPT
// }
// /*
// usercod     bigint(10) AI PK
// useremail   varchar(80)
// username    varchar(80)
// userpswd    varchar(128)
// userfching  datetime
// userpswdest char(3)
// userpswdexp datetime
// userest     char(3)
// useractcod  varchar(128)
// userpswdchg varchar(128)
// usertipo    char(3)
// */

// use Exception;

// class Security extends \Dao\Table
// {
//     static public function getUsuarios($filter = "", $page = -1, $items = 0)
//     {
//         $sqlstr = "";
//         if ($filter == "" && $page == -1 && $items == 0) {
//             $sqlstr = "SELECT * FROM usuario;";
//         } else {
//             // TODO: Terminar consultas FACET
//             if ($page = -1 and $items = 0) {
//                 $sqlstr = sprintf("SELECT * FROM usuarios %s;", $filter);
//             } else {
//                 $offset = ($page - 1 * $items);
//                 $sqlstr = sprintf(
//                     "SELECT * FROM usuarios %s limit %d, %d;",
//                     $filter,
//                     $offset,
//                     $items
//                 );
//             }
//         }
//         return self::obtenerRegistros($sqlstr, array());
//     }

//     static public function newUsuario($email, $password, $username = "Usuario")
//     {
//         if (!\Utilities\Validators::IsValidEmail($email)) {
//             throw new Exception("Correo no es válido");
//         }
//         if (!\Utilities\Validators::IsValidPassword($password)) {
//             throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
//         }

//         if (trim($username) === "") {
//             throw new Exception("Nombre de usuario es requerido");
//         }

//         $existingUser = self::getUsuarioByEmail($email);
//         if ($existingUser) {
//             throw new Exception("Ya existe un usuario registrado con ese correo");
//         }

//         $newUser = self::_usuarioStruct();
//         $hashedPassword = self::_hashPassword($password);

//         unset($newUser["usercod"]);
//         unset($newUser["userfching"]);
//         unset($newUser["userpswdchg"]);

//         $newUser["useremail"] = $email;
//         $newUser["username"] = $username;
//         $newUser["userpswd"] = $hashedPassword;
//         $newUser["userpswdest"] = Estados::ACTIVO;
//         $newUser["userpswdexp"] = date('Y-m-d H:i:s', time() + 7776000);
//         $newUser["userest"] = Estados::ACTIVO;
//         $newUser["useractcod"] = hash("sha256", $email . time());
//         $newUser["usertipo"] = UsuarioTipo::PUBLICO;

//         $sqlIns = "INSERT INTO `usuario` (`useremail`, `username`, `userpswd`,
//             `userfching`, `userpswdest`, `userpswdexp`, `userest`, `useractcod`,
//             `userpswdchg`, `usertipo`)
//             VALUES
//             (:useremail, :username, :userpswd,
//             now(), :userpswdest, :userpswdexp, :userest, :useractcod,
//             now(), :usertipo);";

//         return self::executeNonQuery($sqlIns, $newUser);
//     }

//     static public function getUsuarioByEmail($email)
//     {
//         $sqlstr = "SELECT * from `usuario` where `useremail` = :useremail ;";
//         $params = array("useremail" => $email);

//         return self::obtenerUnRegistro($sqlstr, $params);
//     }

//     static private function _saltPassword($password)
//     {
//         return hash_hmac(
//             "sha256",
//             $password,
//             \Utilities\Context::getContextByKey("PWD_HASH")
//         );
//     }

//     static private function _hashPassword($password)
//     {
//         return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
//     }

//     static public function verifyPassword($raw_password, $hash_password)
//     {
//         return password_verify(
//             self::_saltPassword($raw_password),
//             $hash_password
//         );
//     }

//     static private function _usuarioStruct()
//     {
//         return array(
//             "usercod"      => "",
//             "useremail"    => "",
//             "username"     => "",
//             "userpswd"     => "",
//             "userfching"   => "",
//             "userpswdest"  => "",
//             "userpswdexp"  => "",
//             "userest"      => "",
//             "useractcod"   => "",
//             "userpswdchg"  => "",
//             "usertipo"     => "",
//         );
//     }

//     static public function getFeature($fncod)
//     {
//         $sqlstr = "SELECT * from funciones where fncod=:fncod;";
//         $featuresList = self::obtenerRegistros($sqlstr, array("fncod" => $fncod));
//         return count($featuresList) > 0;
//     }

//     static public function addNewFeature($fncod, $fndsc, $fnest, $fntyp)
//     {
//         $sqlins = "INSERT INTO `funciones` (`fncod`, `fndsc`, `fnest`, `fntyp`)
//             VALUES (:fncod , :fndsc , :fnest , :fntyp );";

//         return self::executeNonQuery(
//             $sqlins,
//             array(
//                 "fncod" => $fncod,
//                 "fndsc" => $fndsc,
//                 "fnest" => $fnest,
//                 "fntyp" => $fntyp
//             )
//         );
//     }

//     static public function getFeatureByUsuario($userCod, $fncod)
//     {
//         $sqlstr = "select * from
//         funciones_roles a inner join roles_usuarios b on a.rolescod = b.rolescod
//         where a.fnrolest = 'ACT' and b.roleuserest='ACT' and b.usercod=:usercod
//         and a.fncod=:fncod limit 1;";
//         $resultados = self::obtenerRegistros(
//             $sqlstr,
//             array(
//                 "usercod" => $userCod,
//                 "fncod" => $fncod
//             )
//         );
//         return count($resultados) > 0;
//     }

//     static public function getRol($rolescod)
//     {
//         $sqlstr = "SELECT * from roles where rolescod=:rolescod;";
//         $featuresList = self::obtenerRegistros($sqlstr, array("rolescod" => $rolescod));
//         return count($featuresList) > 0;
//     }

//     static public function addNewRol($rolescod, $rolesdsc, $rolesest)
//     {
//         $sqlins = "INSERT INTO `roles` (`rolescod`, `rolesdsc`, `rolesest`)
//         VALUES (:rolescod, :rolesdsc, :rolesest);";

//         return self::executeNonQuery(
//             $sqlins,
//             array(
//                 "rolescod" => $rolescod,
//                 "rolesdsc" => $rolesdsc,
//                 "rolesest" => $rolesest
//             )
//         );
//     }

//     static public function isUsuarioInRol($userCod, $rolescod)
//     {
//         $sqlstr = "select * from roles a inner join
//         roles_usuarios b on a.rolescod = b.rolescod where a.rolesest = 'ACT'
//         and b.usercod=:usercod and a.rolescod=:rolescod limit 1;";
//         $resultados = self::obtenerRegistros(
//             $sqlstr,
//             array(
//                 "usercod" => $userCod,
//                 "rolescod" => $rolescod
//             )
//         );
//         return count($resultados) > 0;
//     }

//     static public function getRolesByUsuario($userCod)
//     {
//         $sqlstr = "select * from roles a inner join
//         roles_usuarios b on a.rolescod = b.rolescod where a.rolesest = 'ACT'
//         and b.usercod=:usercod;";
//         $resultados = self::obtenerRegistros(
//             $sqlstr,
//             array(
//                 "usercod" => $userCod
//             )
//         );
//         return $resultados;
//     }

//     static public function removeRolFromUser($userCod, $rolescod)
//     {
//         $sqldel = "UPDATE roles_usuarios set roleuserest='INA' 
//         where rolescod=:rolescod and usercod=:usercod;";
//         return self::executeNonQuery(
//             $sqldel,
//             array("rolescod" => $rolescod, "usercod" => $userCod)
//         );
//     }

//     static public function removeFeatureFromRol($fncod, $rolescod)
//     {
//         $sqldel = "UPDATE funciones_roles set roleuserest='INA'
//         where fncod=:fncod and rolescod=:rolescod;";
//         return self::executeNonQuery(
//             $sqldel,
//             array("fncod" => $fncod, "rolescod" => $rolescod)
//         );
//     }

//     static public function registrarHistorial($usercod, $accion)
//     {
//         $sqlstr = "INSERT INTO historial (usercod, accion, fecha)
//                    VALUES (:usercod, :accion, NOW());";

//         return self::executeNonQuery(
//             $sqlstr,
//             array(
//                 "usercod" => $usercod,
//                 "accion" => $accion
//             )
//         );
//     }

//     static public function actualizarFechaIngreso($usercod)
//     {
//         $sqlstr = "UPDATE usuario SET userfching = NOW() WHERE usercod = :usercod;";

//         return self::executeNonQuery(
//             $sqlstr,
//             array(
//                 "usercod" => $usercod
//             )
//         );
//     }

//     static public function asignarRolPorDefecto($usercod, $rolescod = "USER")
//     {
//         $sqlstr = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch)
//                    VALUES (:usercod, :rolescod, 'ACT', NOW());";

//         return self::executeNonQuery(
//             $sqlstr,
//             array(
//                 "usercod" => $usercod,
//                 "rolescod" => $rolescod
//             )
//         );
//     }

//     static public function getUnAssignedFeatures($rolescod)
//     {

//     }

//     static public function getUnAssignedRoles($userCod)
//     {

//     }

//     private function __construct()
//     {
//     }

//     private function __clone()
//     {
//     }
// }
// 
