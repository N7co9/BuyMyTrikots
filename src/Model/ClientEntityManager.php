<?php declare(strict_types=1);

namespace App\Model;

use App\Core\Mapper\ClientMapper;
use App\Core\SQL\SqlConnector;
use App\Core\DTO\ClientDTO;

class ClientEntityManager
{
    public SqlConnector $sqlConnector;
    public ClientRepository $clientRepository;
    public BasketRepository $basketRepository;

    public function __construct(
    )
    {
        $this->clientRepository = new ClientRepository();
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository();
    }

    public function saveCredentials(ClientDTO $newUser): string
    {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        $params = [
            'username' => $newUser->username,
            'email' => $newUser->email,
            'password' => $newUser->password
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }

    public function addToBasket($itemID, $userID) : string
    {
        if(empty($this->basketRepository->getItemQuantity($itemID))){
            $query = "INSERT INTO user_baskets (item_id, user_id) VALUES (:item_id, :user_id)";

            $params = [
                ':item_id' => $itemID,
                ':user_id' => $userID,
            ];
            return $this->sqlConnector->executeInsertQuery($query, $params);
        }
        return $this->increaseQuantity($itemID, $userID);
    }

    public function removeFromBasket($itemID, $userID) : string
    {
        if(empty($this->basketRepository->getItemQuantity($itemID)) || $this->basketRepository->getItemQuantity($itemID) === [0 => ['quantity' => '0']])
        {
            $query = "DELETE FROM user_baskets WHERE item_id = :item_id AND user_id = :user_id";

            $params = [
                ':item_id' => $itemID,
                ':user_id' => $userID,
            ];

            return $this->sqlConnector->executeDeleteQuery($query, $params);
        }
        return $this->decreaseQuantity($itemID, $userID);
        }

    public function increaseQuantity($itemID, $userID) : string
    {
        $query = "UPDATE user_baskets SET quantity = :quantity WHERE user_id = :user_id AND item_id = :item_id";

        $arrayWithQuantity = $this->basketRepository->getItemQuantity($itemID);
        $quantity = $arrayWithQuantity[0]['quantity'] + 1;

        $params = [
            ':item_id' => $itemID,
            ':user_id' => $userID,
            ':quantity' => $quantity,
        ];

        return $this->sqlConnector->executeInsertQuery($query,  $params);
    }
    public function decreaseQuantity($itemID, $userID) : string
    {
        $query = "UPDATE user_baskets SET quantity = :quantity WHERE user_id = :user_id AND item_id = :item_id";

        $arrayWithQuantity = $this->basketRepository->getItemQuantity($itemID);

        if ($arrayWithQuantity[0]['quantity'] >= 1){
            $quantity = $arrayWithQuantity[0]['quantity'] - 1;
        }else{
            $quantity = $arrayWithQuantity[0]['quantity'];
        }

        $params = [
            ':item_id' => $itemID,
            ':user_id' => $userID,
            ':quantity' => $quantity,
        ];

        return $this->sqlConnector->executeInsertQuery($query,  $params);
    }
}