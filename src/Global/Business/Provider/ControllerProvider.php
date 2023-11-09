<?php
declare(strict_types=1);

namespace App\Global\Business\Provider;

use App\Components\Basket\Communication\Controller\BasketController;
use App\Components\Checkout\Communication\Controller\CheckoutController;
use App\Components\Homepage\Communication\Controller\HomepageController;
use App\Components\Order\Communication\Controller\OrderOverviewController;
use App\Components\ThankYou\Communication\Controller\ThankYouController;
use App\Components\UserRegistration\Communication\UserRegistrationController;
use App\Components\UserSession\Communication\UserLoginController;
use App\Components\UserSession\Communication\UserLogoutController;


class ControllerProvider
{
    public function getList(): array
    {
        return [
            "shop" => HomepageController::class,
            "registration" => UserRegistrationController::class,
            "login" => UserLoginController::class,
            "logout" => UserLogoutController::class,
            "basket" => BasketController::class,
            "checkout" => CheckoutController::class,
            "order-overview" => OrderOverviewController::class,
            "thank-you" => ThankYouController::class
        ];
    }
}