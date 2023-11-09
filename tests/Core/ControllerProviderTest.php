<?php

namespace Core;


use App\Components\Homepage\Communication\Controller\HomepageController;
use App\Components\UserSession\Communication\UserLoginController;
use App\Global\Business\Provider\ControllerProvider;
use PHPUnit\Framework\TestCase;

class ControllerProviderTest extends TestCase
{
    public function testGetList() : void
    {
        $provider = new ControllerProvider();
        $container = $provider->getList();

        self::assertSame(HomepageController::class, $container['shop']);
        self::assertSame(UserLoginController::class, $container['login']);

    }
}