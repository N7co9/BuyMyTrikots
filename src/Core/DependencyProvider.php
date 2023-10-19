<?php

namespace App\Core;

use App\Core\Basket\BasketManipulator;
use App\Core\DTO\ClientDTO;
use App\Core\Mapper\ClientMapper;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;
use App\Core\Session\SessionHandler;
use App\Core\Validation\BillingValidator;
use App\Core\Validation\ClientValidator;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;
use App\Model\OrderEntityManager;
use App\Model\OrderRepository;
use App\Model\PlayerRepository;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(TemplateEngine::class, new TemplateEngine(__DIR__ . '/../../src/View/templates'));
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