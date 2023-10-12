<?php
declare(strict_types=1);

namespace App\Core;

use App\Controller\BasketController;
use App\Controller\CheckoutController;
use App\Controller\ClientLoginController;
use App\Controller\ClientLogoutController;
use App\Controller\ClientRegistrationController;
use App\Controller\HomepageController;
use App\Controller\OrderOverviewController;
use App\Controller\ThankYouController;


class ControllerProvider
{
    public function getList(): array
    {
        return [
            "shop" => HomepageController::class,
            "registration" => ClientRegistrationController::class,
            "login" => ClientLoginController::class,
            "logout" => ClientLogoutController::class,
            "basket" => BasketController::class,
            "checkout" => CheckoutController::class,
            "order-overview" => OrderOverviewController::class,
            "thank-you" => ThankYouController::class
        ];
    }
}