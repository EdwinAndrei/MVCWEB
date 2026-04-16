<?php
namespace Controllers\Sec;

class Logout extends \Controllers\PublicController
{
    public function run(): void
    {
        $user = \Utilities\Security::getUser();

        if ($user && isset($user["usercod"])) {
            \Dao\Security\Security::registrarHistorial(
                $user["usercod"],
                "Cierre de sesión"
            );
        }

        \Utilities\Security::logout();
        \Utilities\Site::redirectTo("index.php");
    }
}

?>
