<?php

namespace App\Core\Basket;

use App\Core\Session\SessionHandler;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;

class BasketManipulator
{
    private ClientRepository $clientRepository;
    private ClientEntityManager $clientEntityManager;
    private SessionHandler $sessionHandler;
    public function __construct()
    {
        $this->sessionHandler = new SessionHandler();
        $this->clientRepository = new ClientRepository();
        $this->clientEntityManager = new ClientEntityManager();
    }

    public function addItemToBasket() : void
    {
       $userID = $this->clientRepository->getUserID($this->sessionHandler->getSessionMail());

       $itemID = $_GET['id'];

       $this->clientEntityManager->addToBasket($itemID, $userID);
    }

    public function removeItemFromBasket() : void
    {
        $userID = $this->clientRepository->getUserID($this->sessionHandler->getSessionMail());

        $itemID = $_GET['id'];

        $this->clientEntityManager->removeFromBasket($itemID, $userID);
    }
}