<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use Utilities\Validators;
use Utilities\Site;

class Register extends PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $txtName = "";
    private $errorEmail = "";
    private $errorPswd = "";
    private $errorName = "";
    private $generalError = "";
    private $hasErrors = false;

    public function run() : void
    {
        if ($this->isPostBack()) {
            $this->txtEmail = $_POST["txtEmail"] ?? "";
            $this->txtPswd = $_POST["txtPswd"] ?? "";
            $this->txtName = $_POST["txtName"] ?? "";

            if (!Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "El correo no tiene el formato adecuado";
                $this->hasErrors = true;
            }

            if (!Validators::IsValidPassword($this->txtPswd)) {
                $this->errorPswd = "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un caracter especial.";
                $this->hasErrors = true;
            }

            if (trim($this->txtName) === "") {
                $this->errorName = "Debe ingresar un nombre";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {
                try {
                    \Dao\Security\Security::newUsuario(
                        $this->txtEmail,
                        $this->txtPswd,
                        $this->txtName
                    );

                    $user = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail);

                    if ($user) {
                        
                        \Dao\Security\Security::asignarRolPorDefecto(
                            $user["usercod"],
                            "USER"
                        );

                        \Utilities\Security::login(
                            $user["usercod"],
                            $user["username"],
                            $user["useremail"]
                        );

                        \Dao\Security\Security::registrarHistorial(
                            $user["usercod"],
                            "Registro de usuario"
                        );
                    }

                    Site::redirectTo("index.php");
                } catch (\Exception $ex) {
                    $this->generalError = $ex->getMessage();
                    $this->hasErrors = true;
                }
            }
        }

        $viewData = get_object_vars($this);
        \Utilities\Site::addLink("public/css/auth.css");
        \Views\Renderer::render("security/sigin", $viewData);
    }
}
?>
