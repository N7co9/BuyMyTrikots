<?php

namespace App\Components\Order\Business;

use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Global\Business\DTO\OrderDTO;

class OrderBusinessFacade implements OrderBusinessFacadeInterface
{
    public function __construct(public OrderRepository $orderRepository)
    {

    }
    public function getOrderInformation() : OrderDTO
    {
     return $this->orderRepository->getOrderInformation();
    }
}