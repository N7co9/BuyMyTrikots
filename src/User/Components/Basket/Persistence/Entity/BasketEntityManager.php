<?php

namespace App\User\Components\Basket\Persistence\Entity;

use App\Global\Persistence\Repository\ClientRepository;
use App\Global\Persistence\SQL\SqlConnector;
use App\User\Components\Basket\Persistence\Repository\BasketRepository;

class BasketEntityManager
{
    public SqlConnector $sqlConnector;
    public ClientRepository $clientRepository;
    public BasketRepository $basketRepository;

    public function __construct()
    {
        $this->clientRepository = new ClientRepository();
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository();
    }

    public function addToBasket($itemID, $userID): string
    {
        if (empty($this->basketRepository->getItemQuantity($itemID))) {
            $query = "INSERT INTO user_baskets (item_id, user_id) VALUES (:item_id, :user_id)";

            $params = [
                ':item_id' => $itemID,
                ':user_id' => $userID,
            ];
            return $this->sqlConnector->executeInsertQuery($query, $params);
        }
        return $this->increaseQuantity($itemID, $userID);
    }

    public function removeFromBasket($itemID, $userID): string
    {
        if (empty($this->basketRepository->getItemQuantity($itemID)) || $this->basketRepository->getItemQuantity($itemID) === [0 => ['quantity' => '1']]) {
            $query = "DELETE FROM user_baskets WHERE item_id = :item_id AND user_id = :user_id";

            $params = [
                ':item_id' => $itemID,
                ':user_id' => $userID,
            ];

            return $this->sqlConnector->executeDeleteQuery($query, $params);
        }
        return $this->decreaseQuantity($itemID, $userID);
    }

    private function increaseQuantity($itemID, $userID): string
    {
        $query = "UPDATE user_baskets SET quantity = :quantity WHERE user_id = :user_id AND item_id = :item_id";

        $arrayWithQuantity = $this->basketRepository->getItemQuantity($itemID);
        $quantity = $arrayWithQuantity[0]['quantity'] + 1;

        $params = [
            ':item_id' => $itemID,
            ':user_id' => $userID,
            ':quantity' => $quantity,
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }

    private function decreaseQuantity($itemID, $userID): string
    {
        $query = "UPDATE user_baskets SET quantity = :quantity WHERE user_id = :user_id AND item_id = :item_id";

        $arrayWithQuantity = $this->basketRepository->getItemQuantity($itemID);

        $quantity = $arrayWithQuantity[0]['quantity'] - 1;

        $params = [
            ':item_id' => $itemID,
            ':user_id' => $userID,
            ':quantity' => $quantity,
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }

    public function emptyBasket(): string
    {
        $userID = $this->clientRepository->getUserID($_SESSION['mail']);
        $query = "DELETE FROM user_baskets WHERE user_id = :user_id";

        $params = [
            ':user_id' => $userID
        ];
        return $this->sqlConnector->executeDeleteQuery($query, $params);
    }
}