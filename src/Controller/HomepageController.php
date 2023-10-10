<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\TemplateEngine;
use App\Model\PlayerRepository;

class HomepageController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private PlayerRepository $playerRepository;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->playerRepository = $container->get(PlayerRepository::class);
    }

    public function dataConstruct()
    {
        $teamID = $_GET['id'];
        $players = $this->playerRepository->getPlayers($teamID);

        $this->templateEngine->addParameter('players', $players);
        $this->templateEngine->setTemplate('homepage.twig');

        return $this->templateEngine;
    }
}