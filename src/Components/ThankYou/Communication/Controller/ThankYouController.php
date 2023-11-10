<?php

namespace App\Components\ThankYou\Communication\Controller;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Order\Business\OrderBusinessFacade;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class ThankYouController implements ControllerInterface
{
    private GlobalPresentationFacade $presentationFacade;

    private BasketBusinessFacade $basketBusinessFacade;
    private OrderBusinessFacade $orderBusinessFacade;

    public function __construct(Container $container)
    {
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
        $this->basketBusinessFacade = $container->get(BasketBusinessFacade::class);
        $this->orderBusinessFacade = $container->get(OrderBusinessFacade::class);
    }
    public function dataConstruct() : GlobalPresentationFacade
    {
        $basket = $this->basketBusinessFacade->getBasketInfo();
        $order = $this->orderBusinessFacade->getOrderInformation();

        $this->orderBusinessFacade->saveOrder($order);
        $orderID = $this->orderBusinessFacade->getOrderId();
        $this->basketBusinessFacade->emptyBasket();

        $this->presentationFacade->addParameter('orderID', $orderID);
        $this->presentationFacade->addParameter('basket', $basket);
        $this->presentationFacade->addParameter('order', $order);
        $this->presentationFacade->setTemplate('thankyou.twig');

        return $this->presentationFacade;
    }
}