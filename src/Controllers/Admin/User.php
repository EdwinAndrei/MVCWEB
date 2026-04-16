<?php

namespace Controllers\Admin;

use Dao\Admin\Users as UsersDAO;
use Controllers\PrivateController;
use Views\Renderer;
use Utilities\Site;
use Controllers\PrivateNoAuthException;

const USER_FORMULARIO_URL = "index.php?page=Admin_User";
const USER_LISTADO_URL    = "index.php?page=Admin_Users";
const USER_XSRF_KEY       = "Admin_User_Formulario";

class User extends PrivateController
{
    private array $viewData = [];
    private array $modes = [
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar Usuario #%s",
        "DSP" => "Detalle de Usuario #%s",
        "DEL" => "Eliminar Usuario #%s",
        "ROL" => "Roles de Usuario #%s"
    ];

    private array $accessControl = [
        "UPD" => "usuarios_listado_UPD",
        "DEL" => "usuarios_listado_DEL",
        "ROL" => "usuarios_listado_ROL"
    ];

    private array $confirmTooltips = [
        "INS" => "",
        "UPD" => "",
        "DSP" => "",
        "DEL" => "¿Está seguro de eliminar este usuario? ¡Esto no se puede revertir!",
        "ROL" => ""
    ];

    private $usercod   = 0;
    private $username  = "";
    private $useremail = "";
    private $userest   = "ACT";
    private $xsrfToken = "";
    private $mode      = "";

    public function run(): void
    {
        $this->LoadPage();

        if ($this->mode === "ROL") {
            $this->manejarRoles();
            return;
        }

        if ($this->isPostBack()) {
            $this->CapturarDatos();
            if ($this->ValidarDatos()) {
                switch ($this->mode) {
                    case "UPD":
                        if (UsersDAO::updateUsuario(
                            $this->usercod,
                            $this->username,
                            $this->useremail,
                            $this->userest
                        ) !== 0) {
                            Site::redirectToWithMsg(USER_LISTADO_URL, "Usuario actualizado satisfactoriamente");
                        }
                        break;
                    case "DEL":
                        if (UsersDAO::deleteUsuario($this->usercod) !== 0) {
                            Site::redirectToWithMsg(USER_LISTADO_URL, "Usuario eliminado satisfactoriamente");
                        }
                        break;
                }
            }
        }

        $this->GenerarViewData();
        Renderer::render("admin/user", $this->viewData);
    }

    private function manejarRoles()
    {
        if ($this->isPostBack()) {
            $accion   = $_POST["accion"] ?? "";
            $rolescod = $_POST["rolescod"] ?? "";
            if ($accion === "asignar") {
                UsersDAO::asignarRol($this->usercod, $rolescod);
            } elseif ($accion === "quitar") {
                UsersDAO::quitarRol($this->usercod, $rolescod);
            }
            Site::redirectToWithMsg(
                USER_FORMULARIO_URL . "&mode=ROL&usercod=" . $this->usercod,
                "Rol actualizado"
            );
        }

        $this->viewData["mode"]       = $this->mode;
        $this->viewData["modeDsc"]    = sprintf($this->modes[$this->mode], $this->usercod);
        $this->viewData["usercod"]    = $this->usercod;
        $this->viewData["username"]   = $this->username;
        $this->viewData["roles"]      = UsersDAO::getRoles();
        $this->viewData["rolesUsuario"] = UsersDAO::getRolesByUsuario($this->usercod);
        $this->viewData["xsrf_token"] = $this->GenerateXSRFToken();
        Renderer::render("admin/user_roles", $this->viewData);
    }

    private function LoadPage()
    {
        $this->mode = $_GET["mode"] ?? '';

        if (!isset($this->modes[$this->mode])) {
            Site::redirectToWithMsg(USER_LISTADO_URL, "Error al cargar formulario, intente de nuevo");
        }

        if (isset($this->accessControl[$this->mode]) && !$this->isFeatureAutorized($this->accessControl[$this->mode])) {
            throw new PrivateNoAuthException();
        }

        $this->usercod = intval($_GET["usercod"] ?? '0');

        if ($this->mode !== "INS" && $this->usercod <= 0) {
            Site::redirectToWithMsg(USER_LISTADO_URL, "Error al cargar formulario, se requiere Id del Usuario");
        } else {
            if ($this->mode !== "INS") {
                $this->CargarDatos();
            }
        }
    }

    private function CargarDatos()
    {
        $tmpUser = UsersDAO::getUsuarioById($this->usercod);

        if (!$tmpUser || count($tmpUser) <= 0) {
            Site::redirectToWithMsg(USER_LISTADO_URL, "No se encontró el Usuario");
        }

        $this->username  = $tmpUser["username"];
        $this->useremail = $tmpUser["useremail"];
        $this->userest   = $tmpUser["userest"];
    }

    private function CapturarDatos()
    {
        $this->usercod   = intval($_POST["usercod"] ?? '0');
        $this->username  = $_POST["username"] ?? '';
        $this->useremail = $_POST["useremail"] ?? '';
        $this->userest   = $_POST["userest"] ?? '';
        $this->xsrfToken = $_POST["uuid"] ?? '';
    }

    private function ValidarDatos()
    {
        $sessionToken = $_SESSION[USER_XSRF_KEY] ?? '';
        if ($this->xsrfToken !== $sessionToken) {
            Site::redirectToWithMsg(USER_LISTADO_URL, "Error de seguridad en la petición");
        }

        $validateId = intval($_GET["usercod"] ?? '0');
        if ($this->mode !== "INS" && $validateId !== $this->usercod) {
            return false;
        }

        if ($this->mode !== "DEL") {
            if (trim($this->username) === "") return false;
            if (trim($this->useremail) === "") return false;
            if (!in_array($this->userest, ["ACT", "INA"])) return false;
        }

        return true;
    }

    private function GenerarViewData()
    {
        $this->viewData["mode"]        = $this->mode;
        $this->viewData["modeDsc"]     = sprintf($this->modes[$this->mode], $this->usercod);
        $this->viewData["usercod"]     = $this->usercod;
        $this->viewData["username"]    = $this->username;
        $this->viewData["useremail"]   = $this->useremail;
        $this->viewData["userest"]     = $this->userest;
        $this->viewData["userest_ACT"] = $this->userest === "ACT" ? "selected" : "";
        $this->viewData["userest_INA"] = $this->userest === "INA" ? "selected" : "";

        if ($this->mode === "DEL" || $this->mode === "DSP") {
            $this->viewData["isReadonly"] = "readonly";
            $this->viewData["isDisabled"] = "disabled";
        } else {
            $this->viewData["isReadonly"] = "";
            $this->viewData["isDisabled"] = "";
        }

        $this->viewData["hideConfirm"]    = $this->mode === "DSP";
        $this->viewData["confirmToolTip"] = $this->confirmTooltips[$this->mode];
        $this->viewData["xsrf_token"]     = $this->GenerateXSRFToken();
    }

    private function GenerateXSRFToken()
    {
        $tmpStr = "user_formulario" . time() . rand(10000, 99999);
        $this->xsrfToken = md5($tmpStr);
        $_SESSION[USER_XSRF_KEY] = $this->xsrfToken;
        return $this->xsrfToken;
    }
}
