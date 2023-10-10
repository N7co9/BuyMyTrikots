<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\TemplateEngine;


class TeamController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private TeamRepository $repository;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->repository = $container->get(TeamRepository::class);
    }

    public function dataConstruct()
    {
        $leagueKey = $_GET['league'];

        $basketballTeamDTOs = $this->repository->getTeams($leagueKey);

        $this->templateEngine->addParameter('teams', $basketballTeamDTOs);

        $this->templateEngine->setTemplate('teams.twig');

        return $this->templateEngine;
    }
}