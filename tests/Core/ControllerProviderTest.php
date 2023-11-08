<?php

namespace Core;


use App\Global\Business\Provider\ControllerProvider;
use App\User\Components\Homepage\Communication\Controller\HomepageController;
use App\User\Components\Login\Communication\Controller\ClientLoginController;
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