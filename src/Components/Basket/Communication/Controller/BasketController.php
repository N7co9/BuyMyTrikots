<?php

namespace App\Components\Basket\Communication\Controller;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;


class BasketController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private BasketBusinessFacade $basketBusinessFacade;
    public SessionHandler $sessionHandler;
    public string $feedback;
    public function __construct(Container $container)
    {
        $this->feedback = '';
        $this->sessionHandler = $container->get(SessionHandler::class);
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->basketBusinessFacade = $container->get(BasketBusinessFacade::class);
    }

    public function dataConstruct() : TemplateEngine
    {
        $action = $_GET['action'] ?? '';

        $actionMap = [
            'add' => 'addItemToBasket',
            'remove' => 'removeItemFromBasket'
        ];

        if (!empty($this->sessionHandler->getSessionMail()) && array_key_exists($action, $actionMap)) {
            $this->feedback = 'successful action';
            $this->basketBusinessFacade->{$actionMap[$action]}();
        }

        $basketContent = $this->basketBusinessFacade->getBasketInfo();
        $total = $this->basketBusinessFacade->getBasketTotal();

        $this->templateEngine->addParameter('contents', $basketContent);
        $this->templateEngine->addParameter('total', $total);
        $this->templateEngine->setTemplate('basket.twig');

        return $this->templateEngine;
    }
}