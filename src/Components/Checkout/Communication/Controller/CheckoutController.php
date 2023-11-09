<?php

namespace App\Components\Checkout\Communication\Controller;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\Checkout\Business\CheckoutBusinessFacade;
use App\Components\Checkout\Business\Validation\BillingValidator;
use App\Components\Order\Business\OrderBusinessFacade;
use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class CheckoutController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private BasketBusinessFacade $basketRepository;
    public CheckoutBusinessFacade $checkoutBusinessFacade;
    public OrderBusinessFacade $orderBusinessFacade;

    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->orderBusinessFacade = $container->get(OrderBusinessFacade::class);
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->basketRepository = $container->get(BasketBusinessFacade::class);
        $this->checkoutBusinessFacade = $container->get(CheckoutBusinessFacade::class);
    }

    public function dataConstruct(): TemplateEngine
    {
        $this->errorDTOList = $this->checkoutBusinessFacade->validate($this->orderBusinessFacade->getOrderInformation());
        $this->checkoutBusinessFacade->redirectIfValid($this->errorDTOList);

        $basket = $this->basketRepository->getBasketInfo();
        $total = $this->basketRepository->getBasketTotal();
        $values = $this->orderBusinessFacade->getOrderInformation();

        $this->templateEngine->setTemplate('checkout.twig');
        $this->templateEngine->addParameter('errors', $this->errorDTOList);
        $this->templateEngine->addParameter('values', $values);
        $this->templateEngine->addParameter('basket', $basket);
        $this->templateEngine->addParameter('total', $total);

        return $this->templateEngine;
    }
}