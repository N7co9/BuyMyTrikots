<?php

namespace App\Global\Business\Provider;

use App\Components\Basket\Persistence\Repository\BasketRepository;

readonly class OrderItemProvider
{
    public function __construct(private BasketRepository $basketRepository)
    {
    }
    public function getItems() : array
    {
        $basket = $this->basketRepository->getBasketInfo();

        $items = [];
        foreach ($basket as $item) {
            $items = [
                'id'       => $item->id,
                'quantity' => $item->quantity,
            ];
        }
        return  $items;
    }
}