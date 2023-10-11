<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\SearchEngine;
use App\Core\TemplateEngine;
use App\Model\PlayerRepository;

class HomepageController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private PlayerRepository $playerRepository;
    private SearchEngine $searchEngine;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->playerRepository = $container->get(PlayerRepository::class);
        $this->searchEngine = $container->get(SearchEngine::class);
    }

    public function dataConstruct()
    {
        $this->searchEngine->search();

        $teamID = $_GET['id'];

        $user = $_SESSION['mail'] ?? '';

        $players = $this->playerRepository->getPlayers($teamID);

        $this->templateEngine->addParameter('user', $user);
        $this->templateEngine->addParameter('players', $players);
        $this->templateEngine->setTemplate('homepage.twig');

        return $this->templateEngine;
    }
}