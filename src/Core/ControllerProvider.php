<?php
declare(strict_types=1);

namespace App\Core;

use App\Controller\ClientRegistrationController;
use App\Controller\HomepageController;


class ControllerProvider
{
    public function getList(): array
    {
        return [
            "shop" => HomepageController::class,
            "registration" => ClientRegistrationController::class,
        ];
    }
}