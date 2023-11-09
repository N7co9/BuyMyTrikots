<?php

namespace App\Components\Basket\Business;

interface BasketBusinessFacadeInterface
{
    public function addItemToBasket();

    public function removeItemFromBasket();
    public function calculateTotal();
    public function getBasketInfo();
    public function getBasketTotal();
}