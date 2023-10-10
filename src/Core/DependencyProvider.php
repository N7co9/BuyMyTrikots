<?php

namespace App\Core;

use App\Core\API\ApiHandling;
use App\Model\LeagueRepository;
use App\Model\TeamRepository;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(TemplateEngine::class, new TemplateEngine(__DIR__ . '/../../src/View/templates'));
        $container->set(ApiHandling::class, new ApiHandling());
        $container->set(TeamRepository::class, new TeamRepository());
        $container->set(LeagueRepository::class, new LeagueRepository());
    }
}