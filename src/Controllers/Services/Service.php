<?php

namespace Controllers\Services;

use Dao\Services\Services as ServicesDAO;
use Controllers\PrivateController;
use Views\Renderer;
use Utilities\Site;
use Controllers\PrivateNoAuthException;

const SERVICES_FORM_URL = "index.php?page=Services_Service";
const SERVICES_LIST_URL = "index.php?page=Services_Services";
const XSRF_KEY = "Services_Service_Form";

class Service extends PrivateController
{
    private array $viewData = [];

    private array $modes = [
        "INS" => "Nuevo Servicio",
        "UPD" => "Actualizar %s %s",
        "DSP" => "Detalle de %s %s",
        "DEL" => "Eliminar %s %s"
    ];

    private array $accessControl = [
        "INS" => "services_listado_INS",
        "UPD" => "services_listado_UPD",
        "DEL" => "services_listado_DEL",
    ];

    private array $confirmTooltips = [
        "INS" => "",
        "UPD" => "",
        "DSP" => "",
        "DEL" => "¿Esta Seguro de Realizar la Eliminación? ¡¡Esto no se puede Revertir!!"
    ];

    private $servicio_id = 0;
    private $nombre = "";
    private $descripcion = "";
    private $precio = "";
    private $estado = "ACT";

    private $xsrfToken = "";
    private $mode = "";

    private $nombreError = "";
    private $descripcionError = "";
    private $precioError = "";

    public function run(): void
    {
        $this->LoadPage();

        if ($this->isPostBack()) {
            $this->CapturarDatos();
            if ($this->ValidarDatos()) {
                switch ($this->mode) {
                    case "INS":
                        if (ServicesDAO::insertService(
                            $this->nombre,
                            $this->descripcion,
                            $this->precio,
                            $this->estado
                        ) !== 0) {
                            Site::redirectToWithMsg(SERVICES_LIST_URL, "Servicio creado satisfactoriamente");
                        }
                        break;

                    case "UPD":
                        if (ServicesDAO::updateService(
                            $this->servicio_id,
                            $this->nombre,
                            $this->descripcion,
                            $this->precio,
                            $this->estado
                        ) !== 0) {
                            Site::redirectToWithMsg(SERVICES_LIST_URL, "Servicio actualizado satisfactoriamente");
                        }
                        break;

                    case "DEL":
                        if (ServicesDAO::deleteService($this->servicio_id) !== 0) {
                            Site::redirectToWithMsg(SERVICES_LIST_URL, "Servicio eliminado satisfactoriamente");
                        }
                        break;
                }
            }
        }

        $this->GenerarViewData();
        Renderer::render("services/service", $this->viewData);
    }

    private function LoadPage()
    {
        $this->mode = $_GET["mode"] ?? '';

        if (!isset($this->modes[$this->mode])) {
            Site::redirectToWithMsg(SERVICES_LIST_URL, "Error al cargar formulario, intente de nuevo");
        }

        if (isset($this->accessControl[$this->mode]) && !$this->isFeatureAutorized($this->accessControl[$this->mode])) {
            throw new PrivateNoAuthException();
        }

        $this->servicio_id = intval($_GET["service_id"] ?? '0');

        if ($this->mode !== "INS" && $this->servicio_id <= 0) {
            Site::redirectToWithMsg(SERVICES_LIST_URL, "Error al cargar formulario, se requiere Id del Servicio");
        } else {
            if ($this->mode !== "INS") {
                $this->CargarDatos();
            }
        }
    }

    private function CargarDatos()
    {
        $tmpService = ServicesDAO::getServiceById($this->servicio_id);

        if (!$tmpService || count($tmpService) <= 0) {
            Site::redirectToWithMsg(SERVICES_LIST_URL, "No se encontró el Servicio");
        }

        $this->nombre = $tmpService["nombre"];
        $this->descripcion = $tmpService["descripcion"];
        $this->precio = $tmpService["precio"];
        $this->estado = $tmpService["estado"];
    }

    private function CapturarDatos()
    {
        $this->servicio_id = intval($_POST["service_id"] ?? '0');
        $this->nombre = $_POST["nombre"] ?? '';
        $this->descripcion = $_POST["descripcion"] ?? '';
        $this->precio = $_POST["precio"] ?? '';
        $this->estado = $_POST["estado"] ?? '';
        $this->xsrfToken = $_POST["uuid"] ?? '';
    }

    private function ValidarDatos()
    {
        $isValid = true;
        $sessionToken = $_SESSION[XSRF_KEY] ?? '';
        if ($this->xsrfToken !== $sessionToken) {
            Site::redirectToWithMsg(SERVICES_LIST_URL, "Error al cargar formulario, inconsistencia en la petición");
        }

        $validateId = intval($_GET["service_id"] ?? '0');
        if ($this->mode !== "INS" && $validateId !== $this->servicio_id) {
            return false;
        }

        if ($this->mode !== "DEL") {
            if (trim($this->nombre) === "") {
                $this->nombreError = "El nombre del servicio es requerido.";
                !$isValid = false;
            }
            if (trim($this->descripcion) === "") {
                $this->descripcionError = "La descripción del servicio es requerida.";
                !$isValid = false;
            }
            if (floatval($this->precio) <= 0) {
                $this->precioError = "Por favor ingrese un precio válido";
                !$isValid = false;
            }
            if (!in_array($this->estado, ["ACT", "IACT"])) {
                !$isValid = false;
            }
        }

        return $isValid;
    }

    private function GenerarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modeDsc"] = sprintf($this->modes[$this->mode], $this->servicio_id, $this->nombre);
        $this->viewData["service_id"] = $this->servicio_id;
        $this->viewData["nombre"] = $this->nombre;
        $this->viewData["descripcion"] = $this->descripcion;
        $this->viewData["precio"] = $this->precio;
        $this->viewData["estado"] = $this->estado;
        $this->viewData["estado_ACT"] = $this->estado === "ACT" ? "selected" : "";
        $this->viewData["estado_IACT"] = $this->estado === "IACT" ? "selected" : "";
        $this->viewData["isReadonly"] = ($this->mode === 'DEL' || $this->mode === 'DSP') ? 'readonly' : '';
        $this->viewData["hideConfirm"] = $this->mode === 'DSP';
        $this->viewData["confirmToolTip"] = $this->confirmTooltips[$this->mode];
        $this->viewData["xsrf_token"] = $this->GenerateXSRFToken();

        $this->viewData["nombreError"] = $this->nombreError;
        $this->viewData["descripcionError"] = $this->descripcionError;
        $this->viewData["precioError"] = $this->precioError;
    }

    private function GenerateXSRFToken()
    {
        $tmpStr = "services_formulario" . time() . rand(10000, 99999);
        $this->xsrfToken = md5($tmpStr);
        $_SESSION[XSRF_KEY] = $this->xsrfToken;
        return $this->xsrfToken;
    }
}
