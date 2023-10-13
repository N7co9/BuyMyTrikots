<?php

namespace Core;


use App\Controller\ClientLoginController;
use App\Controller\HomepageController;
use App\Core\Container;
use App\Core\ControllerProvider;
use PHPUnit\Framework\TestCase;

class ControllerProviderTest extends TestCase
{
    public function testGetList() : void
    {
        $provider = new ControllerProvider();
        $container = $provider->getList();

        self::assertSame(HomepageController::class, $container['shop']);
        self::assertSame(ClientLoginController::class, $container['login']);

    }
}