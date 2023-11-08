<?php
declare(strict_types=1);

namespace App\Global\Business\Provider;

use App\User\Components\Basket\Communication\Controller\BasketController;
use App\User\Components\Checkout\Communication\Controller\CheckoutController;
use App\User\Components\Homepage\Communication\Controller\HomepageController;
use App\User\Components\Login\Communication\Controller\ClientLoginController;
use App\User\Components\Logout\Communication\Controller\ClientLogoutController;
use App\User\Components\Order\Communication\Controller\OrderOverviewController;
use App\User\Components\Registration\Communication\Controller\ClientRegistrationController;
use App\User\Components\ThankYou\Communication\Controller\ThankYouController;


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