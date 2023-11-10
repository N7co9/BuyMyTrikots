<?php

namespace App\Components\Order\Business;

use App\Components\Order\Persistence\Entity\OrderEntityManager;
use App\Components\Order\Persistence\Repository\OrderRepository;
use App\Global\Business\DTO\OrderDTO;

class OrderBusinessFacade implements OrderBusinessFacadeInterface
{
    public function __construct(
        public OrderRepository    $orderRepository,
        public OrderEntityManager $orderEntityManager
    )
    {

    }

    public function getOrderInformation(): OrderDTO
    {
        return $this->orderRepository->getOrderInformation();
    }

    public function getOrderId(): int
    {
        return $this->orderRepository->getOrderId();
    }

    public function saveOrder(OrderDTO $orderDTO): string
    {
        return $this->orderEntityManager->saveOrder($orderDTO);
    }
}