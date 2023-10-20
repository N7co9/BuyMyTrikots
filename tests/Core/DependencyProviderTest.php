<?php

namespace Tests\Core;

use App\Core\Container;
use App\Core\DependencyProvider;
use App\Core\TemplateEngine;
use App\Core\SearchEngine;
use App\Core\Basket\BasketManipulator;
use App\Core\Session\SessionHandler;
use App\Core\Validation\ClientValidator;
use App\Core\Validation\BillingValidator;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;
use App\Core\DTO\ClientDTO;
use App\Core\Mapper\ClientMapper;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;
use App\Model\OrderEntityManager;
use App\Model\OrderRepository;
use App\Model\PlayerRepository;
use PHPUnit\Framework\TestCase;

class DependencyProviderTest extends TestCase
{
    public function testProvide()
    {
        $container = new Container();
        $provider = new DependencyProvider();

        $provider->provide($container);

        // TemplateEngine
        $this->assertTrue($this->instanceInArray(TemplateEngine::class, $container->getList()));
        $this->assertInstanceOf(TemplateEngine::class, $container->get(TemplateEngine::class));
        self::assertObjectHasProperty('twig', $container->get(TemplateEngine::class));
        self::assertSame('/home/nicogruenewald/Documents/BuyMyTrikots/src/Core/../../src/View/templates', $container->get(TemplateEngine::class)->templatePath);

        // PlayerRepository
        $this->assertTrue($this->instanceInArray(PlayerRepository::class, $container->getList()));
        $this->assertInstanceOf(PlayerRepository::class, $container->get(PlayerRepository::class));

        // ClientRepository
        $this->assertTrue($this->instanceInArray(ClientRepository::class, $container->getList()));
        $this->assertInstanceOf(ClientRepository::class, $container->get(ClientRepository::class));

        // ClientEntityManager
        $this->assertTrue($this->instanceInArray(ClientEntityManager::class, $container->getList()));
        $this->assertInstanceOf(ClientEntityManager::class, $container->get(ClientEntityManager::class));

        // ClientMapper
        $this->assertTrue($this->instanceInArray(ClientMapper::class, $container->getList()));
        $this->assertInstanceOf(ClientMapper::class, $container->get(ClientMapper::class));

        // ClientValidator
        $this->assertTrue($this->instanceInArray(ClientValidator::class, $container->getList()));
        $this->assertInstanceOf(ClientValidator::class, $container->get(ClientValidator::class));

        // SearchEngine
        $this->assertTrue($this->instanceInArray(SearchEngine::class, $container->getList()));
        $this->assertInstanceOf(SearchEngine::class, $container->get(SearchEngine::class));

        // ClientDTO
        $this->assertTrue($this->instanceInArray(ClientDTO::class, $container->getList()));
        $this->assertInstanceOf(ClientDTO::class, $container->get(ClientDTO::class));

        // BasketRepository
        $this->assertTrue($this->instanceInArray(BasketRepository::class, $container->getList()));
        $this->assertInstanceOf(BasketRepository::class, $container->get(BasketRepository::class));

        // BasketManipulator
        $this->assertTrue($this->instanceInArray(BasketManipulator::class, $container->getList()));
        $this->assertInstanceOf(BasketManipulator::class, $container->get(BasketManipulator::class));

        // OrderRepository
        $this->assertTrue($this->instanceInArray(OrderRepository::class, $container->getList()));
        $this->assertInstanceOf(OrderRepository::class, $container->get(OrderRepository::class));

        // OrderEntityManager
        $this->assertTrue($this->instanceInArray(OrderEntityManager::class, $container->getList()));
        $this->assertInstanceOf(OrderEntityManager::class, $container->get(OrderEntityManager::class));

        // BillingValidator
        $this->assertTrue($this->instanceInArray(BillingValidator::class, $container->getList()));
        $this->assertInstanceOf(BillingValidator::class, $container->get(BillingValidator::class));

        // RedirectSpy
        $this->assertTrue($this->instanceInArray(RedirectSpy::class, $container->getList()));
        $this->assertInstanceOf(RedirectSpy::class, $container->get(RedirectSpy::class));

        // Redirect
        $this->assertTrue($this->instanceInArray(Redirect::class, $container->getList()));
        $this->assertInstanceOf(Redirect::class, $container->get(Redirect::class));

        // SessionHandler
        $this->assertTrue($this->instanceInArray(SessionHandler::class, $container->getList()));
        $this->assertInstanceOf(SessionHandler::class, $container->get(SessionHandler::class));
    }

    private function instanceInArray(string $class, array $array): bool
    {
        foreach ($array as $instance) {
            if ($instance instanceof $class) {
                return true;
            }
        }

        return false;
    }
}
