<?php

namespace App\Global\Business\Dependency;

use App\Components\Basket\Business\Manipulation\BasketManipulator;
use App\Components\Basket\Business\Manipulation\TotalManipulator;
use App\Components\Basket\Persistence\Entity\BasketEntityManager;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\Checkout\Business\Validation\BillingValidator;
use App\Components\Homepage\Persistence\Repository\PlayerRepository;
use App\Components\Order\Persistence\Entity\OrderEntityManager;
use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Components\User\Business\Validation\UserValidator;
use App\Components\User\Persistence\Entity\UserEntityManager;
use App\Components\User\Persistence\Repository\UserRepository;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ApiMapper;
use App\Global\Business\Mapper\ClientMapper;
use App\Global\Business\Provider\OrderItemProvider;
use App\Global\Business\Redirect\Redirect;
use App\Global\Business\Redirect\RedirectSpy;
use App\Global\Business\Redirect\SearchEngine;
use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;
use App\Global\Persistence\SQL\SqlConnector;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;
use Safe\Exceptions\SessionException;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(TemplateEngine::class, new TemplateEngine(__DIR__ . '/../../Presentation/Templates'));
        $container->set(PlayerRepository::class, new PlayerRepository($container->get(ApiHandling::class), $container->get(ApiMapper::class), $container->get(ApiCache::class)));
        $container->set(UserRepository::class, new UserRepository($container->get(ClientMapper::class), $container->get(SqlConnector::class)));
        $container->set(UserEntityManager::class, new UserEntityManager($container->get(SqlConnector::class)));
        $container->set(ClientMapper::class, new ClientMapper());
        $container->set(UserValidator::class, new UserValidator());
        $container->set(SearchEngine::class, new SearchEngine(new Redirect()));
        $container->set(ClientDTO::class, new ClientDTO());
        $container->set(BasketRepository::class, new BasketRepository($container->get(UserRepository::class), $container->get(ApiHandling::class), $container->get(ApiMapper::class), $container->get(SqlConnector::class), $container->get(ApiCache::class), $container->get(SessionHandler::class)));
        $container->set(OrderRepository::class, new OrderRepository());
        $container->set(OrderEntityManager::class, new OrderEntityManager($container->get(UserRepository::class), $container->get(SqlConnector::class), $container->get(TotalManipulator::class), $container->get(OrderItemProvider::class)));
        $container->set(BillingValidator::class, new BillingValidator(new Redirect()));
        $container->set(RedirectSpy::class, new RedirectSpy());
        $container->set(Redirect::class, new Redirect());
        $container->set(SessionHandler::class, new SessionHandler());
        $container->set(BasketEntityManager::class, new BasketEntityManager($container->get(SqlConnector::class), $container->get(UserRepository::class), $container->get(BasketRepository::class)));
        $container->set(TotalManipulator::class, new TotalManipulator($container->get(BasketRepository::class)));
        $container->set(OrderItemProvider::class, new OrderItemProvider($container->get(BasketRepository::class)));
        $container->set(BasketManipulator::class, new BasketManipulator($container->get(SessionHandler::class), $container->get(UserRepository::class), $container->get(BasketRepository::class)));
    }
}