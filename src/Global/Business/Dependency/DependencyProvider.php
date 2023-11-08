<?php

namespace App\Global\Business\Dependency;

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

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(TemplateEngine::class, new TemplateEngine(__DIR__ . '/../../Presentation/Templates'));
        $container->set(PlayerRepository::class, new PlayerRepository());
        $container->set(ClientRepository::class, new ClientRepository());
        $container->set(ClientEntityManager::class, new ClientEntityManager());
        $container->set(ClientMapper::class, new ClientMapper());
        $container->set(ClientValidator::class, new ClientValidator());
        $container->set(SearchEngine::class, new SearchEngine(new Redirect()));
        $container->set(ClientDTO::class, new ClientDTO());
        $container->set(BasketRepository::class, new BasketRepository());
        $container->set(BasketManipulator::class, new BasketManipulator());
        $container->set(OrderRepository::class, new OrderRepository());
        $container->set(OrderEntityManager::class, new OrderEntityManager());
        $container->set(BillingValidator::class, new BillingValidator(new Redirect()));
        $container->set(RedirectSpy::class, new RedirectSpy());
        $container->set(Redirect::class, new Redirect());
        $container->set(SessionHandler::class, new SessionHandler());
    }
}