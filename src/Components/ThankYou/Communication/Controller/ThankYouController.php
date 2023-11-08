<?php

namespace App\Components\ThankYou\Communication\Controller;

use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\Order\Persistence\Entity\OrderEntityManager;
use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Components\User\Persistence\Entity\UserEntityManager;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class ThankYouController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private OrderRepository $orderRepository;
    private BasketRepository $basketRepository;
    private OrderEntityManager $orderEntityManager;
    private UserEntityManager $clientEntityManager;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->orderRepository = $container->get(OrderRepository::class);
        $this->basketRepository = $container->get(BasketRepository::class);
        $this->orderEntityManager = $container->get(OrderEntityManager::class);
        $this->clientEntityManager = $container->get(UserEntityManager::class);
    }
    public function dataConstruct() : TemplateEngine
    {
        $basket = $this->basketRepository->getBasketInfo();
        $order = $this->orderRepository->getOrderInformation();

        $this->orderEntityManager->saveOrder($order);
        $orderID = $this->orderRepository->getOrderId();
        $this->clientEntityManager->emptyBasket();

        $this->templateEngine->addParameter('orderID', $orderID);
        $this->templateEngine->addParameter('basket', $basket);
        $this->templateEngine->addParameter('order', $order);
        $this->templateEngine->setTemplate('thankyou.twig');

        return $this->templateEngine;
    }
}