<?php

namespace App\Core\Basket;

use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;

class BasketManipulator
{
    private ClientRepository $clientRepository;
    private ClientEntityManager $clientEntityManager;
    public function __construct()
    {
        $this->clientRepository = new ClientRepository();
        $this->clientEntityManager = new ClientEntityManager();
    }

    public function addItemToBasket() : void
    {
       $userID = $this->clientRepository->getUserID($_SESSION['mail']);

       $itemID = $_GET['id'];

       $this->clientEntityManager->addToBasket($itemID, $userID);
    }

    public function removeItemFromBasket() : void
    {
        $userID = $this->clientRepository->getUserID($_SESSION['mail']);

        $itemID = $_GET['id'];

        $this->clientEntityManager->removeFromBasket($itemID, $userID);
    }
}