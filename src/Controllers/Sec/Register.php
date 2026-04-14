<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use \Utilities\Validators;


class Register extends PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $txtName = "";
    private $errorEmail ="";
    private $errorPswd = "";
    private $errorName = "";
    private $hasErrors = false;

    public function run() :void
    {

        if ($this->isPostBack()) {

            $this->txtEmail = $_POST["txtEmail"];
            $this->txtPswd = $_POST["txtPswd"];
            $this->txtName = $_POST["txtName"];

            if (!Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "Correo inválido";
                $this->hasErrors = true;
            }

            if (!Validators::IsValidPassword($this->txtPswd)) {
                $this->errorPswd = "Contraseña débil";
                $this->hasErrors = true;
            }

            if (trim($this->txtName) === "") {
                $this->errorName = "Ingrese un nombre";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {

                $hashed = password_hash($this->txtPswd, PASSWORD_DEFAULT);

                \Dao\Table::executeNonQuery(
                    "INSERT INTO usuario (useremail, username, userpswd, userest, userfching)
                     VALUES (:email, :name, :pswd, 'ACT', NOW())",
                    [
                        "email" => $this->txtEmail,
                        "name" => $this->txtName,
                        "pswd" => $hashed
                    ]
                );

                $user = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail);

                \Utilities\Security::login(
                    $user["usercod"],
                    $user["username"],
                    $user["useremail"]
                );

                \Dao\Table::executeNonQuery(
                    "INSERT INTO historial (usercod, accion, fecha)
                     VALUES (:usercod, 'Registro de usuario', NOW())",
                    ["usercod" => $user["usercod"]]
                );

                \Utilities\Site::redirectTo("index.php");
            }
        }

        $viewData = get_object_vars($this);
        \Views\Renderer::render("security/usuario", $viewData);
    }
}
?>
