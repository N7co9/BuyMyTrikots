<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\TemplateEngine;
use App\Core\Validation\BillingValidator;
use App\Model\BasketRepository;
use App\Model\OrderRepository;

class CheckoutController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private BasketRepository $basketRepository;
    private OrderRepository $orderRepository;
    public BillingValidator $billingValidator;

    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->orderRepository = $container->get(OrderRepository::class);
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->basketRepository = $container->get(BasketRepository::class);
        $this->billingValidator = $container->get(BillingValidator::class);
    }

    public function dataConstruct(): TemplateEngine
    {
        $this->errorDTOList = $this->billingValidator->validate($this->orderRepository->getOrderInformation());
        $this->billingValidator->redirectIfValid($this->errorDTOList);

        $basket = $this->basketRepository->getBasketInfo();
        $total = $this->basketRepository->getBasketTotal();
        $values = $this->orderRepository->getOrderInformation();

        $this->templateEngine->setTemplate('checkout.twig');
        $this->templateEngine->addParameter('errors', $this->errorDTOList);
        $this->templateEngine->addParameter('values', $values);
        $this->templateEngine->addParameter('basket', $basket);
        $this->templateEngine->addParameter('total', $total);

        return $this->templateEngine;
    }
}