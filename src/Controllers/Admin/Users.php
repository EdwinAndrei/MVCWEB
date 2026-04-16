<?php

namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Users as DaoUsers;
use Views\Renderer;

const USERS_LIST_VIEW_TEMPLATE = "admin/users";

class Users extends PrivateController
{
    private array $usuariosList = [];

    public function run(): void
    {
        $this->usuariosList = DaoUsers::getUsuarios();

        foreach ($this->usuariosList as &$usuario) {
            if ($usuario["userest"] === "ACT") {
                $usuario["userestDsc"] = "Activo";
            } else {
                $usuario["userestDsc"] = "Inactivo";
            }
        }

        Renderer::render(USERS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "usuarios"    => $this->usuariosList,
            "showUpdate"  => $this->isFeatureAutorized("usuarios_listado_UPD"),
            "showDelete"  => $this->isFeatureAutorized("usuarios_listado_DEL"),
            "showRoles"   => $this->isFeatureAutorized("usuarios_listado_ROL"),
            "showActions" => (
                $this->isFeatureAutorized("usuarios_listado_UPD") ||
                $this->isFeatureAutorized("usuarios_listado_DEL") ||
                $this->isFeatureAutorized("usuarios_listado_ROL")
            )
        ];
    }
}
