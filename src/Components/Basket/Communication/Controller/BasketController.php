<?php

namespace App\Components\Basket\Communication\Controller;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;


class BasketController implements ControllerInterface
{
    private BasketBusinessFacade $basketBusinessFacade;
    private GlobalPresentationFacade $presentationFacade;
    public string $feedback;
    public function __construct(Container $container)
    {
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
        $this->feedback = '';
        $this->basketBusinessFacade = $container->get(BasketBusinessFacade::class);
    }

    public function dataConstruct() : GlobalPresentationFacade
    {
        $action = $_GET['action'] ?? '';

        $actionMap = [
            'add' => 'addItemToBasket',
            'remove' => 'removeItemFromBasket'
        ];

        if (!empty($this->presentationFacade->getSessionMail()) && array_key_exists($action, $actionMap)) {
            $this->feedback = 'successful action';
            $this->basketBusinessFacade->{$actionMap[$action]}();
        }

        $basketContent = $this->basketBusinessFacade->getBasketInfo();
        $total = $this->basketBusinessFacade->getBasketTotal();

        $this->presentationFacade->addParameter('contents', $basketContent);
        $this->presentationFacade->addParameter('total', $total);
        $this->presentationFacade->setTemplate('basket.twig');

        return $this->presentationFacade;
    }
}