<?php

namespace Controllers\Admin;

use Controllers\PrivateController;
use Views\Renderer;

class Admin extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        $this->viewData["adminName"] = \Utilities\Security::getUser()["userName"];
        Renderer::render("admin/admin", $this->viewData);
    }
}
?>