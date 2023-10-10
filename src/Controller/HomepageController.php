<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\TemplateEngine;
use App\Model\LeagueRepository;

class HomepageController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
    }

    public function dataConstruct()
    {
        $this->templateEngine->setTemplate('homepage.twig');

        return $this->templateEngine;
    }
}