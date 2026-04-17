<?php

namespace Controllers;

use Controllers\PublicController;
use Views\Renderer;

class HomeController extends PublicController
{
    private $viewData = [];

    public function run(): void
    {
        \Utilities\Site::addLink("public/css/heropanel.css");
        Renderer::render("home/home", $this->viewData);
    }
}
