<?php

namespace App\Model;

use App\Core\DTO\OrderDTO;
use App\Core\SQL\SqlConnector;
use App\Core\TotalCalculator;
use JsonException;

class OrderEntityManager
{
    private ClientRepository $clientRepository;
    private SqlConnector $sqlConnector;
    private TotalCalculator $totalCalculator;
    private OrderItemProvider $itemProvider;
    public function __construct()
    {
        $this->itemProvider = new OrderItemProvider();
        $this->clientRepository = new ClientRepository();
        $this->sqlConnector = new SqlConnector();
        $this->totalCalculator = new TotalCalculator();
    }

    /**
     * @throws JsonException
     */
    public function saveOrder(OrderDTO $orderDTO) : string
    {
        $query = "INSERT INTO orders (user_id, firstName, lastName, city, zip, delivery, payment, email, items, total) VALUES (:user_id, :firstName, :lastName, :city, :zip, :delivery, :payment, :email, :items, :total)";

        $items = $this->itemProvider->getItems();

        $encodedItems= json_encode($items[0], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT, 512);

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
            ':items' => $encodedItems,
            ':total' => $total
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }
}