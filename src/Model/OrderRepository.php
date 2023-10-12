<?php

namespace App\Model;

use App\Core\DTO\OrderDTO;
use App\Core\Mapper\BillingMapper;
use App\Core\SQL\SqlConnector;
use App\Core\TotalCalculator;

class OrderRepository
{
    private TotalCalculator $calculator;
    private BillingMapper $billingMapper;
    private SqlConnector $sqlConnector;
    private ClientRepository $clientRepository;

    public function __construct()
    {
        $this->calculator = new TotalCalculator();
        $this->billingMapper = new BillingMapper();
        $this->sqlConnector = new SqlConnector();
        $this->clientRepository = new ClientRepository();
    }

    public function getOrderInformation(): OrderDTO
    {
        $dataKeys = ["first_name", "last_name", "address", "city", "zip", "payment", "delivery"];

        foreach ($dataKeys as $key) {
            if (isset($_POST[$key])) {
                $_SESSION[$key] = $_POST[$key];
            }
        }

        $billingArray = [
            "firstName" => $_SESSION['first_name'] ?? '',
            "lastName" => $_SESSION['last_name'] ?? '',
            "address" => $_SESSION['address'] ?? '',
            "city" => $_SESSION['city'] ?? '',
            "zip" => $_SESSION['zip'] ?? '',
            "delivery" => $_SESSION['delivery'] ?? '',
            "totalDue" => $this->calculator->calculateTotal() ?? 0.00,
            "payment" => $_SESSION['payment'] ?? '',
            "email" => $_SESSION['mail'] ?? ''
        ];

        return $this->billingMapper->mapBilling($billingArray);
    }
    public function getOrderId() : int
    {
        $query = "SELECT orders.id FROM orders WHERE orders.user_id = :user_id ORDER BY orders.id DESC LIMIT 1";

        $userID = $this->clientRepository->getUserID($_SESSION['mail']);

        $params = [
            ":user_id" => $userID,
        ];

        $array = $this->sqlConnector->executeSelectQuery($query, $params);

        return $array[0]['id'];
    }
}