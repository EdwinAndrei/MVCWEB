<?php

namespace Controllers\Sec;

class Login extends \Controllers\PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $errorEmail = "";
    private $errorPswd = "";
    private $generalError = "";
    private $hasError = false;

    public function run(): void
    {
        if (!isset($_SESSION["login_attempts"])) {
            $_SESSION["login_attempts"] = 0;
        }

        if ($this->isPostBack()) {

            if ($_SESSION["login_attempts"] >= 30) {
                $this->generalError = "Demasiados intentos fallidos. Intente más tarde.";
                $dataView = get_object_vars($this);
                \Utilities\Site::addLink("public/css/auth.css");
                \Views\Renderer::render("security/login", $dataView);
                return;
            }

            $this->txtEmail = $_POST["txtEmail"] ?? "";
            $this->txtPswd = $_POST["txtPswd"] ?? "";

            if (!\Utilities\Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "¡Correo no tiene el formato adecuado!";
                $this->hasError = true;
            }

            if (\Utilities\Validators::IsEmpty($this->txtPswd)) {
                $this->errorPswd = "¡Debe ingresar una contraseña!";
                $this->hasError = true;
            }

            if (!$this->hasError) {
                $dbUser = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail);

                if ($dbUser) {
                    if ($dbUser["userest"] != \Dao\Security\Estados::ACTIVO) {
                        $this->generalError = "¡Credenciales son incorrectas!";
                        $this->hasError = true;
                        $_SESSION["login_attempts"]++;

                        error_log(
                            sprintf(
                                "ERROR: %d %s tiene cuenta con estado %s",
                                $dbUser["usercod"],
                                $dbUser["useremail"],
                                $dbUser["userest"]
                            )
                        );
                    }

                    if (
                        !$this->hasError &&
                        !\Dao\Security\Security::verifyPassword($this->txtPswd, $dbUser["userpswd"])
                    ) {
                        $this->generalError = "¡Credenciales son incorrectas!";
                        $this->hasError = true;
                        $_SESSION["login_attempts"]++;

                        error_log(
                            sprintf(
                                "ERROR: %d %s contraseña incorrecta",
                                $dbUser["usercod"],

                                $dbUser["useremail"]

                            )
                        );
                    }

                    if (!$this->hasError) {
                        \Utilities\Security::login(
                            $dbUser["usercod"],
                            $dbUser["username"],
                            $dbUser["useremail"]

                        );
                        //LOG para admin agregado
                        \Dao\Admin\Logs::registrar(
                            $dbUser["usercod"],
                            "Login — " . $dbUser["useremail"]
                        );
                        //termina aqui

                        $_SESSION["login_attempts"] = 0;

                        \Dao\Security\Security::registrarHistorial(
                            $dbUser["usercod"],
                            "Inicio de sesión"
                        );

                        \Dao\Security\Security::actualizarFechaIngreso(
                            $dbUser["usercod"]
                        );

                        if (\Utilities\Context::getContextByKey("redirto") !== "") {
                            \Utilities\Site::redirectTo(
                                \Utilities\Context::getContextByKey("redirto")
                            );
                        } else {
                            \Utilities\Site::redirectTo("index.php?page=Home_Home");
                        }
                    }
                } else {

                    $_SESSION["login_attempts"]++;

                    error_log(
                        sprintf(
                            "ERROR: %s trato de ingresar",
                            $this->txtEmail
                        )
                    );

                    $this->generalError = "¡Credenciales son incorrectas!";
                }
            }
        }

        $dataView = get_object_vars($this);
        \Utilities\Site::addLink("public/css/auth.css");
        \Views\Renderer::render("security/login", $dataView);
    }
}
