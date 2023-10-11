<?php

namespace App\Model;

use App\Core\API\ApiHandling;
use App\Core\Mapper\ApiMapper;
use App\Core\SQL\SqlConnector;

class BasketRepository
{
    private ClientRepository $clientRepository;
    private ApiHandling $apiHandling;
    private ApiMapper $apiMapper;

    private SqlConnector $sqlConnector;
    public function __construct()
    {
        $this->clientRepository = new ClientRepository();
        $this->apiHandling = new ApiHandling();
        $this->apiMapper = new ApiMapper();
        $this->sqlConnector = new SqlConnector();
    }
    public function getBasketInfo() : array
    {
        $basketIDs = $this->clientRepository->getBasketContent($this->clientRepository->getUserID($_SESSION['mail']));

        $itemInfoDTOArray =  [];
        foreach ($basketIDs as $item){
            $itemInfoArray = $this->apiHandling->requestItemInfo($item);
            $itemInfoDTOArray [] = $this->apiMapper->MapBasket($itemInfoArray, $this->getItemQuantity($item['item_id']));
        }

        return $itemInfoDTOArray;
    }
    public function getItemQuantity($itemID) : array
    {
        $userID = $this->clientRepository->getUserID($_SESSION['mail']);
        return $this->sqlConnector->executeSelectQuery("SELECT user_baskets.quantity FROM user_baskets WHERE user_baskets.user_id = :user_id AND user_baskets.item_id = :item_id", [":user_id" => $userID, ":item_id" => $itemID]);
    }
}