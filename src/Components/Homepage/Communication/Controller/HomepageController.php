<?php

namespace App\Components\Homepage\Communication\Controller;

use App\Components\Homepage\Business\HomepageBusinessFacade;
use App\Components\Homepage\Business\SearchEngine;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class HomepageController implements ControllerInterface
{
    private HomepageBusinessFacade $homepageBusinessFacade;
    private GlobalPresentationFacade $presentationFacade;
    public function __construct(Container $container)
    {
        $this->homepageBusinessFacade = $container->get(HomepageBusinessFacade::class);
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
    }

    public function dataConstruct() : GlobalPresentationFacade
    {
        $this->homepageBusinessFacade->search();

        $teamID = $_GET['id'] ?? null;

        $user = $this->presentationFacade->getSessionMail();

        $players = $this->homepageBusinessFacade->getPlayers($teamID);

        $this->presentationFacade->addParameter('user', $user);
        $this->presentationFacade->addParameter('players', $players);
        $this->presentationFacade->setTemplate('homepage.twig');

        return $this->presentationFacade;
    }
}