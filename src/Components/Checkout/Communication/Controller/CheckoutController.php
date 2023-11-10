<?php

namespace App\Components\Checkout\Communication\Controller;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\Checkout\Business\CheckoutBusinessFacade;
use App\Components\Order\Business\OrderBusinessFacade;
use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class CheckoutController implements ControllerInterface
{
    private GlobalPresentationFacade $presentationFacade;
    private BasketBusinessFacade $basketRepository;
    public CheckoutBusinessFacade $checkoutBusinessFacade;
    public OrderBusinessFacade $orderBusinessFacade;

    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->orderBusinessFacade = $container->get(OrderBusinessFacade::class);
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
        $this->basketRepository = $container->get(BasketBusinessFacade::class);
        $this->checkoutBusinessFacade = $container->get(CheckoutBusinessFacade::class);
    }

    public function dataConstruct(): GlobalPresentationFacade
    {
        $this->errorDTOList = $this->checkoutBusinessFacade->validate($this->orderBusinessFacade->getOrderInformation());
        $this->checkoutBusinessFacade->redirectIfValid($this->errorDTOList);

        $basket = $this->basketRepository->getBasketInfo();
        $total = $this->basketRepository->getBasketTotal();
        $values = $this->orderBusinessFacade->getOrderInformation();

        $this->presentationFacade->setTemplate('checkout.twig');
        $this->presentationFacade->addParameter('errors', $this->errorDTOList);
        $this->presentationFacade->addParameter('values', $values);
        $this->presentationFacade->addParameter('basket', $basket);
        $this->presentationFacade->addParameter('total', $total);

        return $this->presentationFacade;
    }
}