<?php

namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Logs as DaoLogs;
use Views\Renderer;

const LOGS_LIST_VIEW_TEMPLATE = "admin/logs";

class Logs extends PrivateController
{
    private array $logsList = [];

    public function run(): void
    {
        $this->logsList = DaoLogs::getLogs();

        Renderer::render(LOGS_LIST_VIEW_TEMPLATE, $this->prepareViewData());
    }

    private function prepareViewData()
    {
        return [
            "logs" => $this->logsList
        ];
    }
}
?>