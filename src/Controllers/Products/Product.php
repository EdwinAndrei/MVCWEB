<?php

namespace Controllers\Products;

use Dao\Products\Products as ProductsDAO;
use Controllers\PrivateController;
use Views\Renderer;
use Utilities\Site;
use Controllers\PrivateNoAuthException;

const PRODUCTS_FORMULARIO_URL = "index.php?page=Products_Product";
const PRODUCTS_LISTADO_URL = "index.php?page=Products_Products";
const XSRF_KEY = "Products_Product_Formulario";

class Product extends PrivateController
{
    private array $viewData = [];
    private array $modes = [
        "INS" => "Nuevo Producto",
        "UPD" => "Actualizar %s %s",
        "DSP" => "Detalle de %s %s",
        "DEL" => "Eliminar %s %s"
    ];

    private array $accessControl = [
        "INS" => "productos_listado_INS",
        "UPD" => "productos_listado_UPD",
        "DEL" => "productos_listado_DEL",
    ];

    private array $confirmTooltips = [
        "INS" => "",
        "UPD" => "",
        "DSP" => "",
        "DEL" => "¿Esta Seguro de Realizar la Eliminación? ¡¡Esto no se puede Revertir!!"
    ];

    private $productId = 0;
    private $productName = "";
    private $productDescription = "";
    private $productPrice = "";
    private $productImgUrl = "";
    private $productStock = "";
    private $productStatus = "ACT";

    private $xsrfToken = "";
    private $mode = "";

    public function run(): void
    {
        $this->LoadPage();

        if ($this->isPostBack()) {
            $this->CapturarDatos();
            if ($this->ValidarDatos()) {
                switch ($this->mode) {
                    case "INS":
                        if (ProductsDAO::insertProduct(
                            $this->productName,
                            $this->productDescription,
                            $this->productPrice,
                            $this->productImgUrl,
                            $this->productStock,
                            $this->productStatus
                        ) !== 0) {
                            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Producto creado satisfactoriamente");
                        }
                        break;

                    case "UPD":
                        if (ProductsDAO::updateProduct(
                            $this->productId,
                            $this->productName,
                            $this->productDescription,
                            $this->productPrice,
                            $this->productImgUrl,
                            $this->productStock,
                            $this->productStatus
                        ) !== 0) {
                            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Producto actualizado satisfactoriamente");
                        }
                        break;

                    case "DEL":
                        if (ProductsDAO::deleteProduct($this->productId) !== 0) {
                            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Producto eliminado satisfactoriamente");
                        }
                        break;
                }
            }
        }

        $this->GenerarViewData();
        Renderer::render("products/product", $this->viewData);
    }

    private function LoadPage()
    {
        $this->mode = $_GET["mode"] ?? '';

        if (!isset($this->modes[$this->mode])) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Error al cargar formulario, intente de nuevo");
        }

        if (isset($this->accessControl[$this->mode]) && !$this->isFeatureAutorized($this->accessControl[$this->mode])) {
            throw new PrivateNoAuthException();
        }

        $this->productId = intval($_GET["productId"] ?? '0');

        if ($this->mode !== "INS" && $this->productId <= 0) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Error al cargar formulario, se requiere Id del Producto");
        } else {
            if ($this->mode !== "INS") {
                $this->CargarDatos();
            }
        }
    }

    private function CargarDatos()
    {
        $tmpProduct = ProductsDAO::getProductById($this->productId);

        if (!$tmpProduct || count($tmpProduct) <= 0) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "No se encontró el Producto");
        }

        $this->productName = $tmpProduct["productName"];
        $this->productDescription = $tmpProduct["productDescription"];
        $this->productPrice = $tmpProduct["productPrice"];
        $this->productImgUrl = $tmpProduct["productImgUrl"];
        $this->productStock = $tmpProduct["productStock"];
        $this->productStatus = $tmpProduct["productStatus"];
    }

    private function CapturarDatos()
    {
        $this->productId = intval($_POST["productId"] ?? '0');
        $this->productName = $_POST["productName"] ?? '';
        $this->productDescription = $_POST["productDescription"] ?? '';
        $this->productPrice = $_POST["productPrice"] ?? '';
        $this->productImgUrl = $_POST["productImgUrl"] ?? '';
        $this->productStock = $_POST["productStock"] ?? '';
        $this->productStatus = $_POST["productStatus"] ?? '';
        $this->xsrfToken = $_POST["uuid"] ?? '';
    }

    private function ValidarDatos()
    {
        $sessionToken = $_SESSION[XSRF_KEY] ?? '';
        if ($this->xsrfToken !== $sessionToken) {
            Site::redirectToWithMsg(PRODUCTS_LISTADO_URL, "Error al cargar formulario, inconsistencia en la petición");
        }

        $validateId = intval($_GET["productId"] ?? '0');
        if ($this->mode !== "INS" && $validateId !== $this->productId) {
            return false;
        }

        if ($this->mode !== "DEL") {
            if (trim($this->productName) === "") {
                return false;
            }
            if (trim($this->productDescription) === "") {
                return false;
            }
            if (floatval($this->productPrice) <= 0) {
                return false;
            }
            if (trim($this->productImgUrl) === "") {
                return false;
            }
            if (intval($this->productStock) < 0) {
                return false;
            }
            if (!in_array($this->productStatus, ["ACT", "INA"])) {
                return false;
            }
        }

        return true;
    }

    private function GenerarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modeDsc"] = sprintf($this->modes[$this->mode], $this->productId, $this->productName);
        $this->viewData["productId"] = $this->productId;
        $this->viewData["productName"] = $this->productName;
        $this->viewData["productDescription"] = $this->productDescription;
        $this->viewData["productPrice"] = $this->productPrice;
        $this->viewData["productImgUrl"] = $this->productImgUrl;
        $this->viewData["productStock"] = $this->productStock;
        $this->viewData["productStatus"] = $this->productStatus;
        $this->viewData["productStatus_ACT"] = $this->productStatus === "ACT" ? "selected" : "";
        $this->viewData["productStatus_INA"] = $this->productStatus === "INA" ? "selected" : "";
        $this->viewData["isReadonly"] = ($this->mode === 'DEL' || $this->mode === 'DSP') ? 'readonly' : '';
        $this->viewData["hideConfirm"] = $this->mode === 'DSP';
        $this->viewData["confirmToolTip"] = $this->confirmTooltips[$this->mode];
        $this->viewData["xsrf_token"] = $this->GenerateXSRFToken();
    }

    private function GenerateXSRFToken()
    {
        $tmpStr = "products_formulario" . time() . rand(10000, 99999);
        $this->xsrfToken = md5($tmpStr);
        $_SESSION[XSRF_KEY] = $this->xsrfToken;
        return $this->xsrfToken;
    }
}
