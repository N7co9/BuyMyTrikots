<?php

namespace App\Components\Basket\Persistence\Repository;

use App\Components\User\Persistence\Repository\UserRepository;
use App\Global\Business\Mapper\ApiMapper;
use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;
use App\Global\Persistence\SQL\SqlConnector;
use App\Global\Presentation\Session\SessionHandler;

class BasketRepository
{
    public function __construct(
        private readonly UserRepository $userRepository, private readonly ApiHandling $apiHandling, private readonly ApiMapper $apiMapper,
        private readonly SqlConnector   $sqlConnector, private ApiCache $apiCache, private readonly SessionHandler $sessionHandler
    )
    {
        $this->apiCache = new ApiCache($this->apiHandling);
    }
    public function getBasketInfo() : array
    {
        $basketIDs = $this->getBasketContent($this->userRepository->getUserID($this->sessionHandler->getSessionMail()));

        $itemInfoDTOArray =  [];
        foreach ($basketIDs as $item){
            $itemInfoArray = $this->apiCache->getData('item', $item['item_id']);
            $itemInfoDTOArray [] = $this->apiMapper->MapBasket($itemInfoArray, $this->getItemQuantity($item['item_id']));
        }
        return $itemInfoDTOArray;
    }
    private function getBasketContent($userID) : array
    {
        return $this->sqlConnector->executeSelectQuery("SELECT user_baskets.item_id FROM user_baskets where user_baskets.user_id = :user_id", [':user_id' => $userID]);
    }
    public function getItemQuantity($itemID) : array
    {
        $userID = $this->userRepository->getUserID($this->sessionHandler->getSessionMail());
        return $this->sqlConnector->executeSelectQuery("SELECT user_baskets.quantity FROM user_baskets WHERE user_baskets.user_id = :user_id AND user_baskets.item_id = :item_id", [":user_id" => $userID, ":item_id" => $itemID]);
    }

    public function getBasketTotal() : ?string
    {
        $array = $this->getBasketInfo();
        $price = 0;
        foreach ($array as $item)
        {
            if($item->quantity >= 2){
                $item->price *= $item->quantity;
            }
            $price = $item->price;
        }
        return $price ?? null;
    }
}