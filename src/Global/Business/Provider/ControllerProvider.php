<?php
declare(strict_types=1);

namespace App\Global\Business\Provider;

use App\Components\Basket\Communication\Controller\BasketController;
use App\Components\Checkout\Communication\Controller\CheckoutController;
use App\Components\Homepage\Communication\Controller\HomepageController;
use App\Components\Order\Communication\Controller\OrderOverviewController;
use App\Components\ThankYou\Communication\Controller\ThankYouController;
use App\Components\User\Communication\Controller\UserLoginController;
use App\Components\User\Communication\Controller\UserLogoutController;
use App\Components\User\Communication\Controller\UserRegistrationController;


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