<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\TemplateEngine;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\OrderEntityManager;
use App\Model\OrderRepository;

class ThankYouController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private OrderRepository $orderRepository;
    private BasketRepository $basketRepository;
    private OrderEntityManager $orderEntityManager;
    private ClientEntityManager $clientEntityManager;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->orderRepository = $container->get(OrderRepository::class);
        $this->basketRepository = $container->get(BasketRepository::class);
        $this->orderEntityManager = $container->get(OrderEntityManager::class);
        $this->clientEntityManager = $container->get(ClientEntityManager::class);

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