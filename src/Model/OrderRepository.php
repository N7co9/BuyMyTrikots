<?php

namespace App\Model;

use App\Core\DTO\OrderDTO;
use App\Core\Mapper\BillingMapper;
use App\Core\Session\SessionHandler;
use App\Core\SQL\SqlConnector;
use App\Core\TotalCalculator;

class OrderRepository
{
    private TotalCalculator $calculator;
    private BillingMapper $billingMapper;
    private SqlConnector $sqlConnector;
    private ClientRepository $clientRepository;
    private SessionHandler $sessionHandler;

    public function __construct()
    {
        $this->calculator = new TotalCalculator();
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