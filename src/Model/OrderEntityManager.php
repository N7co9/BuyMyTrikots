<?php

namespace App\Model;

use App\Core\DTO\OrderDTO;
use App\Core\SQL\SqlConnector;
use App\Core\TotalCalculator;

class OrderEntityManager
{
    private ClientRepository $clientRepository;
    private SqlConnector $sqlConnector;
    private BasketRepository $basketRepository;
    private TotalCalculator $totalCalculator;
    public function __construct()
    {
        $this->clientRepository = new ClientRepository();
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository();
        $this->totalCalculator = new TotalCalculator();
    }
    public function saveOrder(OrderDTO $orderDTO) : string
    {
        $query = "INSERT INTO orders (user_id, firstName, lastName, city, zip, delivery, payment, email, items, total) VALUES (:user_id, :firstName, :lastName, :city, :zip, :delivery, :payment, :email, :items, :total)";

        $basket = $this->basketRepository->getBasketInfo();

        $items = [];
        foreach ($basket as $item) {
            $items[] = [
                'id'       => $item->id,
                'quantity' => $item->quantity,
            ];
        }

        $items = json_encode($items, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT, 512);

        $total = $this->totalCalculator->calculateTotal();

        $params = [
            ':user_id' => $this->clientRepository->getUserID($_SESSION['mail']),
            ':firstName' => $orderDTO->firstName,
            ':lastName' => $orderDTO->lastName,
            ':city' => $orderDTO->city,
            ':zip' => $orderDTO->zip,
            ':delivery' => $orderDTO->delivery,
            ':payment' => $orderDTO->paymentMethod,
            ':email' => $orderDTO->email,
            ':items' => $items,
            ':total' => $total
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }
}