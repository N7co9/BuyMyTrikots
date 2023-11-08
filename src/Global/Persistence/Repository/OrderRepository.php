<?php

namespace App\Global\Persistence\Repository;

use App\Global\Business\DTO\OrderDTO;
use App\Global\Business\Mapper\BillingMapper;
use App\Global\Persistence\SQL\SqlConnector;
use App\Global\Presentation\Session\SessionHandler;
use App\User\Components\Basket\Business\Manipulation\TotalManipulator;

class OrderRepository
{
    private TotalManipulator $calculator;
    private BillingMapper $billingMapper;
    private SqlConnector $sqlConnector;
    private ClientRepository $clientRepository;
    private SessionHandler $sessionHandler;

    public function __construct()
    {
        $this->calculator = new TotalManipulator();
        $this->billingMapper = new BillingMapper();
        $this->sqlConnector = new SqlConnector();
        $this->clientRepository = new ClientRepository();
        $this->sessionHandler = new SessionHandler();
    }

    public function getOrderInformation(): OrderDTO
    {
        $dataKeys = ["first_name", "last_name", "address", "city", "zip", "payment", "delivery"];

        $this->sessionHandler->setOrderSession($dataKeys);

        $billingArray = $this->sessionHandler->getOrderSession();

        $billingArray['totalDue'] = $this->calculator->calculateTotal();

        return $this->billingMapper->mapBilling($billingArray);
    }
    public function getOrderId() : int
    {
        $query = "SELECT orders.id FROM orders WHERE orders.user_id = :user_id ORDER BY orders.id DESC LIMIT 1";

        $userID = $this->clientRepository->getUserID($this->sessionHandler->getSessionMail());

        $params = [
            ":user_id" => $userID,
        ];

        $array = $this->sqlConnector->executeSelectQuery($query, $params);

        return $array[0]['id'];
    }
}