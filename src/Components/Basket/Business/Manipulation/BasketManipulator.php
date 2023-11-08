<?php

namespace App\Components\Basket\Business\Manipulation;

use App\Components\Basket\Persistence\Entity\BasketEntityManager;
use App\Components\User\Persistence\Repository\UserRepository;
use App\Global\Presentation\Session\SessionHandler;

readonly class BasketManipulator
{
    public function __construct(private SessionHandler $sessionHandler, private UserRepository $userRepository, private BasketEntityManager $basketEntityManager)
    {
    }

    public function addItemToBasket() : void
    {
       $userID = $this->userRepository->getUserID($this->sessionHandler->getSessionMail());

       $itemID = $_GET['id'];

       $this->basketEntityManager->addToBasket($itemID, $userID);
    }

    public function removeItemFromBasket() : void
    {
        $userID = $this->userRepository->getUserID($this->sessionHandler->getSessionMail());

        $itemID = $_GET['id'];

        $this->basketEntityManager->removeFromBasket($itemID, $userID);
    }
}