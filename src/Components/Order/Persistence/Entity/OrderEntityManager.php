<?php

namespace App\Components\Order\Persistence\Entity;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\OrderDTO;
use App\Global\Business\Provider\OrderItemProvider;
use App\Global\Persistence\SQL\SqlConnector;

class OrderEntityManager
{
    public function __construct(
        private UserRepository   $userRepository,
        private SqlConnector $sqlConnector,
        private BasketBusinessFacade $basketBusinessFacade,
        private OrderItemProvider $itemProvider
    )
    {
    }

    public function saveOrder(OrderDTO $orderDTO): string
    {
        $query = "INSERT INTO orders (user_id, firstName, lastName, city, zip, delivery, payment, email, items, total) VALUES (:user_id, :firstName, :lastName, :city, :zip, :delivery, :payment, :email, :items, :total)";

        $items = $this->itemProvider->getItems();

        $encodedItems = json_encode($items);

        $total = $this->basketBusinessFacade->calculateTotal();

        $params = [
            ':user_id' => $this->userRepository->getUserID($_SESSION['mail']),
            ':firstName' => $orderDTO->firstName,
            ':lastName' => $orderDTO->lastName,
            ':city' => $orderDTO->city,
            ':zip' => $orderDTO->zip,
            ':delivery' => $orderDTO->delivery,
            ':payment' => $orderDTO->paymentMethod,
            ':email' => $orderDTO->email,
            ':items' => $encodedItems,
            ':total' => $total
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }
}