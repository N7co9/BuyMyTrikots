<?php

namespace Tests\Core;

use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ClientMapper;
use App\Global\Business\Redirect\Redirect;
use App\Global\Business\Redirect\RedirectSpy;
use App\Global\Business\Redirect\SearchEngine;
use App\Global\Persistence\Repository\ClientRepository;
use App\Global\Persistence\Repository\OrderRepository;
use App\Global\Persistence\Repository\PlayerRepository;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;
use App\User\Components\Basket\Business\Manipulation\BasketManipulator;
use App\User\Components\Basket\Persistence\Repository\BasketRepository;
use App\User\Components\Checkout\Business\Validation\BillingValidator;
use App\User\Components\Order\Persistence\Entity\OrderEntityManager;
use App\User\Components\Registration\Business\Validation\ClientValidator;
use App\User\Components\Registration\Persistence\Entity\ClientEntityManager;
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
