<?php

namespace App\Components\Homepage\Communication\Controller;

use App\Components\Homepage\Persistence\Repository\PlayerRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Business\Redirect\SearchEngine;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class HomepageController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private PlayerRepository $playerRepository;
    public SearchEngine $searchEngine;
    private SessionHandler $sessionHandler;
    public function __construct(Container $container)
    {
        $this->sessionHandler = $container->get(SessionHandler::class);
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->playerRepository = $container->get(PlayerRepository::class);
        $this->searchEngine = $container->get(SearchEngine::class);
    }

    public function dataConstruct() : TemplateEngine
    {
        $this->searchEngine->search();

        $teamID = $_GET['id'] ?? null;

        $user = $this->sessionHandler->getSessionMail();

        $players = $this->playerRepository->getPlayers($teamID);

        $this->templateEngine->addParameter('user', $user);
        $this->templateEngine->addParameter('players', $players);
        $this->templateEngine->setTemplate('homepage.twig');

        return $this->templateEngine;
    }
}