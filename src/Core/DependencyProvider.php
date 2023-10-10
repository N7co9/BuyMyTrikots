<?php

namespace App\Core;

use App\Core\Mapper\ClientMapper;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;
use App\Model\PlayerRepository;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(TemplateEngine::class, new TemplateEngine(__DIR__ . '/../../src/View/templates'));
        $container->set(PlayerRepository::class, new PlayerRepository());
        $container->set(ClientRepository::class, new ClientRepository());
        $container->set(ClientEntityManager::class, new ClientEntityManager(new ClientMapper()));
        $container->set(ClientMapper::class, new ClientMapper());
        $container->set(ClientValidator::class, new ClientValidator());
    }
}