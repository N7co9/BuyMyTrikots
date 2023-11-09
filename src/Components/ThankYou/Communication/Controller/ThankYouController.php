<?php

namespace App\Components\ThankYou\Communication\Controller;

use App\Components\Basket\Persistence\Entity\BasketEntityManager;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\Order\Persistence\Entity\OrderEntityManager;
use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class ThankYouController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private OrderRepository $orderRepository;
    private BasketRepository $basketRepository;
    private OrderEntityManager $orderEntityManager;
    private BasketEntityManager $basketEntityManager;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->orderRepository = $container->get(OrderRepository::class);
        $this->basketRepository = $container->get(BasketRepository::class);
        $this->orderEntityManager = $container->get(OrderEntityManager::class);
        $this->basketEntityManager = $container->get(BasketEntityManager::class);
    }
    public function dataConstruct() : TemplateEngine
    {
        $basket = $this->basketRepository->getBasketInfo();
        $order = $this->orderRepository->getOrderInformation();

        $this->orderEntityManager->saveOrder($order);
        $orderID = $this->orderRepository->getOrderId();
        $this->basketEntityManager->emptyBasket();

        $this->templateEngine->addParameter('orderID', $orderID);
        $this->templateEngine->addParameter('basket', $basket);
        $this->templateEngine->addParameter('order', $order);
        $this->templateEngine->setTemplate('thankyou.twig');

        return $this->templateEngine;
    }
}