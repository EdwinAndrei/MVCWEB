<?php
namespace Controllers\Sec;

class Logout extends \Controllers\PublicController
{
    public function run(): void
    {
        $user = \Utilities\Security::getUser();

        if ($user && isset($user["usercod"])) {
            \Dao\Table::executeNonQuery(
                "INSERT INTO historial (usercod, accion, fecha)
                 VALUES (:usercod, :accion, NOW())",
                [
                    "usercod" => $user["usercod"],
                    "accion" => "Cierre de sesión"
                ]
            );
        }

        \Utilities\Security::logout();
        \Utilities\Site::redirectTo("index.php");
    }
}

?>
