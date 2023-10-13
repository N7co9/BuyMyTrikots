<?php

namespace Core;

use App\Controller\HomepageController;
use App\Core\Container;
use App\Core\TotalCalculator;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGetList() : void
    {
        $container = new Container();

        $container->set(\stdClass::class, new \stdClass());

        $output = $container->getList();
        $get = $container->get(\stdClass::class);


        self::assertInstanceOf(\stdClass::class, $get);
        self::assertIsObject($output['stdClass']);
    }
}