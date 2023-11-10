<?php

namespace App\Global\Business\Dependency;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Basket\Business\Manipulation\BasketManipulator;
use App\Components\Basket\Business\Manipulation\TotalManipulator;
use App\Components\Basket\Persistence\Entity\BasketEntityManager;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\Checkout\Business\CheckoutBusinessFacade;
use App\Components\Checkout\Business\Validation\BillingValidator;
use App\Components\Homepage\Business\HomepageBusinessFacade;
use App\Components\Homepage\Business\SearchEngine;
use App\Components\Homepage\Persistence\Repository\PlayerRepository;
use App\Components\Order\Business\OrderBusinessFacade;
use App\Components\Order\Persistence\Entity\OrderEntityManager;
use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Components\UserRegistration\Business\UserRegistrationBusinessFacade;
use App\Components\UserRegistration\Business\Validation\UserValidator;
use App\Components\UserRegistration\Persistence\UserEntityManager;
use App\Components\UserSession\Business\UserSessionBusinessFacade;
use App\Components\UserSession\Persistence\UserCredentialsRepository;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ApiMapper;
use App\Global\Business\Mapper\BillingMapper;
use App\Global\Business\Mapper\ClientMapper;
use App\Global\Business\Provider\OrderItemProvider;
use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;
use App\Global\Persistence\SQL\SqlConnector;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\Redirect\Redirect;
use App\Global\Presentation\Redirect\RedirectSpy;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        // API and SQL connections
        $container->set(ApiMapper::class, new ApiMapper());
        $container->set(SqlConnector::class, new SqlConnector());
        $container->set(ApiHandling::class, new ApiHandling());
        $container->set(ApiCache::class, new ApiCache($container->get(ApiHandling::class)));

        // Presentation Layer Dependencies
        $container->set(TemplateEngine::class, new TemplateEngine(__DIR__ . '/../../Presentation/Templates'));
        $container->set(SessionHandler::class, new SessionHandler());
        $container->set(RedirectSpy::class, new RedirectSpy());
        $container->set(Redirect::class, new Redirect());
        $container->set(GlobalPresentationFacade::class, new GlobalPresentationFacade(
            $container->get(TemplateEngine::class),
            $container->get(SessionHandler::class),
            $container->get(Redirect::class)
        ));

        // User Registration and Session Dependencies
        $container->set(ClientMapper::class, new ClientMapper());
        $container->set(UserValidator::class, new UserValidator());
        $container->set(UserRepository::class, new UserRepository($container->get(ClientMapper::class), $container->get(SqlConnector::class)));
        $container->set(UserCredentialsRepository::class, new UserCredentialsRepository($container->get(UserRepository::class), $container->get(ClientMapper::class)));
        $container->set(UserEntityManager::class, new UserEntityManager($container->get(SqlConnector::class)));
        $container->set(UserSessionBusinessFacade::class, new UserSessionBusinessFacade(
            $container->get(UserRepository::class),
            $container->get(UserCredentialsRepository::class)
        ));
        $container->set(UserRegistrationBusinessFacade::class, new UserRegistrationBusinessFacade(
            $container->get(UserValidator::class),
            $container->get(UserRepository::class),
            $container->get(UserEntityManager::class)
        ));

        // Basket and Checkout Dependencies
        $container->set(BillingMapper::class, new BillingMapper());
        $container->set(BillingValidator::class, new BillingValidator(new Redirect()));
        $container->set(CheckoutBusinessFacade::class, new CheckoutBusinessFacade($container->get(BillingValidator::class)));
        $container->set(BasketRepository::class, new BasketRepository(
            $container->get(UserSessionBusinessFacade::class),
            $container->get(ApiMapper::class),
            $container->get(SqlConnector::class),
            $container->get(ApiCache::class),
            $container->get(SessionHandler::class)
        ));
        $container->set(TotalManipulator::class, new TotalManipulator($container->get(BasketRepository::class)));
        $container->set(BasketEntityManager::class, new BasketEntityManager(
            $container->get(SqlConnector::class),
            $container->get(UserSessionBusinessFacade::class),
            $container->get(BasketRepository::class)
        ));
        $container->set(BasketManipulator::class, new BasketManipulator(
            $container->get(SessionHandler::class),
            $container->get(UserRepository::class),
            $container->get(BasketEntityManager::class)
        ));
        $container->set(BasketBusinessFacade::class, new BasketBusinessFacade(
            $container->get(BasketManipulator::class),
            $container->get(TotalManipulator::class),
            $container->get(BasketRepository::class),
            $container->get(BasketEntityManager::class)
        ));

        // Homepage and Order Management Dependencies
        $container->set(ClientDTO::class, new ClientDTO());
        $container->set(PlayerRepository::class, new PlayerRepository(
            $container->get(ApiHandling::class),
            $container->get(ApiMapper::class),
            $container->get(ApiCache::class)
        ));
        $container->set(SearchEngine::class, new SearchEngine(new Redirect()));
        $container->set(HomepageBusinessFacade::class, new HomepageBusinessFacade(
            $container->get(PlayerRepository::class),
            $container->get(SearchEngine::class)
        ));
        $container->set(OrderRepository::class, new OrderRepository(
            $container->get(BasketBusinessFacade::class),
            $container->get(BillingMapper::class),
            $container->get(SqlConnector::class),
            $container->get(UserRepository::class),
            $container->get(SessionHandler::class)
        ));
        $container->set(OrderItemProvider::class, new OrderItemProvider($container->get(BasketRepository::class)));
        $container->set(OrderEntityManager::class, new OrderEntityManager(
            $container->get(UserRepository::class),
            $container->get(SqlConnector::class),
            $container->get(BasketBusinessFacade::class),
            $container->get(OrderItemProvider::class)
        ));
        $container->set(OrderBusinessFacade::class, new OrderBusinessFacade(
            $container->get(OrderRepository::class),
            $container->get(OrderEntityManager::class)
        ));
    }
}
