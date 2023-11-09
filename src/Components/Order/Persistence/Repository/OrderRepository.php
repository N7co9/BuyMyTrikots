<?php

namespace App\Components\Order\Persistence\Repository;

use App\Components\Basket\Business\BasketBusinessFacade;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\OrderDTO;
use App\Global\Business\Mapper\BillingMapper;
use App\Global\Persistence\SQL\SqlConnector;
use App\Global\Presentation\Session\SessionHandler;

class OrderRepository
{
    public function __construct(
        private BasketBusinessFacade $basketBusinessFacade,
        private BillingMapper    $billingMapper,
        private SqlConnector     $sqlConnector,
        private UserRepository   $userRepository,
        private SessionHandler   $sessionHandler)
    {
    }

    public function getOrderInformation(): OrderDTO
    {
        $dataKeys = ["first_name", "last_name", "address", "city", "zip", "payment", "delivery"];

        $this->sessionHandler->setOrderSession($dataKeys);

        $billingArray = $this->sessionHandler->getOrderSession();

        $billingArray['totalDue'] = $this->basketBusinessFacade->calculateTotal();

        return $this->billingMapper->mapBilling($billingArray);
    }

    public function getOrderId(): int
    {
        $query = "SELECT orders.id FROM orders WHERE orders.user_id = :user_id ORDER BY orders.id DESC LIMIT 1";

        $userID = $this->userRepository->getUserID($this->sessionHandler->getSessionMail());

        $params = [
            ":user_id" => $userID,
        ];

        $array = $this->sqlConnector->executeSelectQuery($query, $params);

        return $array[0]['id'];
    }
}