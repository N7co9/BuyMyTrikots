<?php

namespace App\User\Components\Order\Communication\Controller;

use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Persistence\Repository\OrderRepository;
use App\Global\Presentation\TemplateEngine\TemplateEngine;
use App\User\Components\Basket\Persistence\Repository\BasketRepository;

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