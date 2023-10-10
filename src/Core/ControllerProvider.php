<?php
declare(strict_types=1);

namespace App\Core;

use App\Controller\HomepageController;
use App\Controller\TeamController;


class ControllerProvider
{
    public function getList(): array
    {
        return [
            "" => HomepageController::class,
            "teams" => TeamController::class,
        ];
    }
}