<?php

namespace App\Model;

class OrderItemProvider
{
    private BasketRepository $basketRepository;
    public function __construct()
    {
        $this->basketRepository = new BasketRepository();
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