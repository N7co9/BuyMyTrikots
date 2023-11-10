<?php

namespace App\Components\Order\Communication\Controller;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Order\Business\OrderBusinessFacade;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class OrderOverviewController implements ControllerInterface
{
    private GlobalPresentationFacade $presentationFacade;
    private OrderBusinessFacade $orderBusinessFacade;
    private BasketBusinessFacade $basketBusinessFacade;
    public function __construct(Container $container)
    {
        $this->orderBusinessFacade = $container->get(OrderBusinessFacade::class);
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
        $this->basketBusinessFacade = $container->get(BasketBusinessFacade::class);
    }
    public function dataConstruct() : GlobalPresentationFacade
    {
        $order = $this->orderBusinessFacade->getOrderInformation();
        $basket = $this->basketBusinessFacade->getBasketInfo();

        $this->presentationFacade->addParameter('order', $order);
        $this->presentationFacade->addParameter('basket', $basket);
        $this->presentationFacade->setTemplate('orderoverview.twig');

        return $this->presentationFacade;
    }
}