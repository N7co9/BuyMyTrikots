<?php

namespace App\User\Components\Basket\Business\Manipulation;

use App\Global\Persistence\Repository\ClientRepository;
use App\Global\Presentation\Session\SessionHandler;
use App\User\Components\Basket\Persistence\Entity\BasketEntityManager;

class BasketManipulator
{
    private ClientRepository $clientRepository;
    private BasketEntityManager $basketEntityManager;
    private SessionHandler $sessionHandler;
    public function __construct()
    {
        $this->sessionHandler = new SessionHandler();
        $this->clientRepository = new ClientRepository();
        $this->basketEntityManager = new BasketEntityManager();
    }

    public function addItemToBasket() : void
    {
       $userID = $this->clientRepository->getUserID($this->sessionHandler->getSessionMail());

       $itemID = $_GET['id'];

       $this->basketEntityManager->addToBasket($itemID, $userID);
    }

    public function removeItemFromBasket() : void
    {
        $userID = $this->clientRepository->getUserID($this->sessionHandler->getSessionMail());

        $itemID = $_GET['id'];

        $this->basketEntityManager->removeFromBasket($itemID, $userID);
    }
}