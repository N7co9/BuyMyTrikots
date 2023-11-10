<?php

namespace App\Components\Basket\Business;

use App\Components\Basket\Business\Manipulation\BasketManipulator;
use App\Components\Basket\Business\Manipulation\TotalManipulator;
use App\Components\Basket\Persistence\Entity\BasketEntityManager;
use App\Components\Basket\Persistence\Repository\BasketRepository;

class BasketBusinessFacade implements BasketBusinessFacadeInterface
{
    public function __construct(
        public BasketManipulator $basketManipulator,
        public TotalManipulator $totalManipulator,
        public BasketRepository $basketRepository,
        public BasketEntityManager $basketEntityManager
    )
    {
    }

    public function addItemToBasket() : void
    {
        $this->basketManipulator->addItemToBasket();
    }
    public function removeItemFromBasket() : void
    {
        $this->basketManipulator->removeItemFromBasket();
    }

    public function calculateTotal() : float
    {
        return $this->totalManipulator->calculateTotal();
    }
    public function getBasketInfo() : array
    {
        return $this->basketRepository->getBasketInfo();
    }

    public function getBasketTotal() : ?string
    {
        return $this->basketRepository->getBasketTotal();
    }

    public function getItemQuantity($itemID) : array
    {
        return $this->basketRepository->getItemQuantity($itemID);
    }
    public function emptyBasket() : string
    {
        return  $this->basketEntityManager->emptyBasket();
    }

}