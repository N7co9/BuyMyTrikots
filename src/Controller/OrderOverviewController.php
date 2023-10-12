<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\TemplateEngine;
use App\Model\BasketRepository;
use App\Model\OrderRepository;

class OrderOverviewController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private OrderRepository $orderRepository;
    private BasketRepository $basketRepository;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->orderRepository = $container->get(OrderRepository::class);
        $this->basketRepository = $container->get(BasketRepository::class);
    }
    public function dataConstruct() : TemplateEngine
    {
        $order = $this->orderRepository->getOrderInformation();
        $basket = $this->basketRepository->getBasketInfo();

        $this->templateEngine->addParameter('order', $order);
        $this->templateEngine->addParameter('basket', $basket);
        $this->templateEngine->setTemplate('orderoverview.twig');

        return $this->templateEngine;
    }
}