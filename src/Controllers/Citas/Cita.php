<?php

namespace Controllers\Citas;

use Dao\Citas\Citas as CitasDAO;
use Dao\Services\Services as ServicesDAO;
use Controllers\PrivateController;
use Views\Renderer;
use Utilities\Site;
use Utilities\Security;
use Controllers\PrivateNoAuthException;

const CITAS_FORMULARIO_URL = "index.php?page=Citas_Cita";
const CITAS_LISTADO_URL = "index.php?page=Citas_Citas";
const XSRF_KEY = "Citas_Cita_Formulario";

class Cita extends PrivateController
{
    private array $viewData = [];
    private array $modes = [
        "INS" => "Agendar cita",
        "UPD" => "Actualizar cita #%s",
        "DSP" => "Detalle de cita #%s",
        "DEL" => "Eliminar cita #%s"
    ];

    private array $accessControl = [
        "INS" => "citas_listado_INS",
        "UPD" => "citas_listado_UPD",
        "DEL" => "citas_listado_DEL",
    ];

    private array $confirmTooltips = [
        "INS" => "",
        "UPD" => "",
        "DSP" => "",
        "DEL" => "¿Esta Seguro de Realizar la Eliminación? ¡¡Esto no se puede Revertir!!"
    ];

    private $id = 0;
    private $usercod = "";
    private $servicio_id = "";
    private $fecha = "";
    private $hora = "";
    private $estado = "";
    private $username = "";

    private $xsrfToken = "";
    private $mode = "";

    private $fechaError = "";
    private $horaError = "";

    public function run(): void
    {
        $this->LoadPage();
        $this->usercod = Security::getUserId();
        $this->username = Security::getUser()["userName"];

        if ($this->isPostBack()) {
            $this->CapturarDatos();
            if ($this->ValidarDatos()) {
                switch ($this->mode) {
                    case "INS":
                        if (CitasDAO::insertCita(
                            $this->usercod,
                            $this->servicio_id,
                            $this->fecha,
                            $this->hora,
                            $this->estado
                        ) !== 0) {
                            // LOG ADMIN
                            \Dao\Admin\Logs::registrar(
                                \Utilities\Security::getUserId(),
                                "Cita agendada — Servicio ID: " . $this->servicio_id . " Fecha: " . $this->fecha . " " . $this->hora
                            );
                            //
                            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Cita agendada satisfactoriamente");
                        }
                        break;
                    case "UPD":
                        if (CitasDAO::updateCita(
                            $this->id,
                            $this->usercod,
                            $this->servicio_id,
                            $this->fecha,
                            $this->hora,
                            $this->estado
                        ) !== 0) {
                            // LOG ADMIN
                            \Dao\Admin\Logs::registrar(
                                \Utilities\Security::getUserId(),
                                "Cita actualizada — ID: " . $this->id . " Estado: " . $this->estado
                            );
                            //
                            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Cita actualizada satisfactoriamente");
                        }
                        break;

                    case "DEL":
                        if (CitasDAO::deleteCita($this->id) !== 0) {
                            //ADMIN LOG
                            \Dao\Admin\Logs::registrar(
                                \Utilities\Security::getUserId(),
                                "Cita eliminada — ID: " . $this->id
                            );
                            //
                            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Cita eliminada satisfactoriamente");
                        }
                        break;
                }
            }
        }

        $this->GenerarViewData();
        Renderer::render("citas/cita", $this->viewData);
    }


    private function LoadPage()
    {
        $this->mode = $_GET["mode"] ?? '';

        if (!isset($this->modes[$this->mode])) {
            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Error al cargar formulario, intente de nuevo");
        }

        if (isset($this->accessControl[$this->mode]) && !$this->isFeatureAutorized($this->accessControl[$this->mode])) {
            throw new PrivateNoAuthException();
        }

        $this->id = intval($_GET["id"] ?? '0');

        if ($this->mode !== "INS" && $this->id <= 0) {
            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Error al cargar formulario, se requiere Id de la Cita");
        } else {
            if ($this->mode !== "INS") {
                $this->CargarDatos();
            }
        }
    }

    private function CargarDatos()
    {
        $tmpCita = CitasDAO::getCitaById($this->id);

        if (!$tmpCita || count($tmpCita) <= 0) {
            Site::redirectToWithMsg(CITAS_LISTADO_URL, "No se encontró la Cita");
        }

        // 🔒 VALIDACIÓN DE SEGURIDAD
        $currentUser = Security::getUserId();

        if (
            Security::isInRol($currentUser, "USER") &&
            intval($tmpCita["usercod"]) !== intval($currentUser)
        ) {
            throw new PrivateNoAuthException();
        }

        $this->usercod = $tmpCita["usercod"];
        $this->servicio_id = $tmpCita["servicio_id"];
        $this->fecha = $tmpCita["fecha"];
        $this->hora = $tmpCita["hora"];
        $this->estado = $tmpCita["estado"];
        $this->username = $tmpCita["username"];
    }

    private function CapturarDatos()
    {
        $this->id = intval($_POST["id"] ?? '0');
        $this->usercod = $_POST["usercod"] ?? '';
        $this->servicio_id = $_POST["servicio_id"] ?? '';
        $this->fecha = $_POST["fecha"] ?? '';
        $this->hora = $_POST["hora"] ?? '';
        $this->estado = $_POST["estado"] ?? '';
        $this->xsrfToken = $_POST["uuid"] ?? '';
    }

    private function ValidarDatos()
    {
        $isValid = true;
        $sessionToken = $_SESSION[XSRF_KEY] ?? '';
        if ($this->xsrfToken !== $sessionToken) {
            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Error al cargar formulario, inconsistencia en la petición");
        }

        $validateId = intval($_GET["id"] ?? '0');
        if ($validateId !== $this->id) {
            $isValid = false;
        }

        if (CitasDAO::verificaCitaHorario(intval($this->usercod), $this->fecha, $this->hora, intval($this->id))) {
            Site::redirectToWithMsg(CITAS_LISTADO_URL, "Ese usuario ya tiene una cita registrada en esa fecha y hora");
        }

        if ($this->mode !== "DEL") {
            if (intval($this->usercod) <= 0) {
                $isValid = false;
            }
            if (intval($this->servicio_id) <= 0) {
                $isValid = false;
            }
            if (trim($this->fecha) === "") {
                $this->fechaError = "La fecha es requerida";
                $isValid = false;
            }
            $fechaActual = date("Y-m-d");
            if ($this->fecha < $fechaActual) {
                $this->fechaError = "No se puede agendar en fechas anteriores";
                $isValid = false;
            }
            if (trim($this->hora) === "") {
                $this->horaError = "La hora es requerida";
                $isValid = false;
            }
            if (!in_array($this->estado, ["pendiente", "confirmada", "cancelada"])) {
                $isValid = false;
            }
        }

        return $isValid;
    }

    private function GenerarViewData()
    {
        $services = ServicesDAO::getServices();

        foreach ($services as &$service) {
            if (intval($service["servicio_id"]) === intval($this->servicio_id)) {
                $service["selected"] = "selected";
            } else {
                $service["selected"] = "";
            }
        }

        $this->viewData["mode"] = $this->mode;
        $this->viewData["modeDsc"] = sprintf($this->modes[$this->mode], $this->id);
        $this->viewData["id"] = $this->id;
        $this->viewData["usercod"] = $this->usercod;
        $this->viewData["servicio_id"] = $this->servicio_id;
        $this->viewData["fechaHoy"] = date("Y-m-d");
        $this->viewData["fecha"] = $this->fecha;
        $this->viewData["hora"] = $this->hora;
        $this->viewData["estado"] = $this->estado;
        $this->viewData["services"] = $services;
        $this->viewData["username"] = $this->username;

        $this->viewData["fechaError"] = $this->fechaError;
        $this->viewData["horaError"] = $this->horaError;

        if ($this->estado === "pendiente") {
            $this->viewData["estado_pendiente"] = "selected";
        } else {
            $this->viewData["estado_pendiente"] = "";
        }

        if ($this->estado === "confirmada") {
            $this->viewData["estado_confirmada"] = "selected";
        } else {
            $this->viewData["estado_confirmada"] = "";
        }

        if ($this->estado === "cancelada") {
            $this->viewData["estado_cancelada"] = "selected";
        } else {
            $this->viewData["estado_cancelada"] = "";
        }

        if ($this->mode === 'DEL' || $this->mode === 'DSP') {
            $this->viewData["isReadonly"] = "readonly";
            $this->viewData["isDisabled"] = "disabled";
        } else {
            $this->viewData["isReadonly"] = "";
            $this->viewData["isDisabled"] = "";
        }

        $this->viewData["hideConfirm"] = $this->mode === 'DSP';
        $this->viewData["confirmToolTip"] = $this->confirmTooltips[$this->mode];
        $this->viewData["xsrf_token"] = $this->GenerateXSRFToken();
    }

    private function GenerateXSRFToken()
    {
        $tmpStr = "citas_formulario" . time() . rand(10000, 99999);
        $this->xsrfToken = md5($tmpStr);
        $_SESSION[XSRF_KEY] = $this->xsrfToken;
        return $this->xsrfToken;
    }
}
