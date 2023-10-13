<?php

namespace Model;

use App\Core\DTO\ClientDTO;
use App\Core\DTO\OrderDTO;
use App\Core\SQL\SqlConnector;
use App\Model\ClientEntityManager;
use App\Model\OrderEntityManager;
use App\Model\OrderRepository;
use App\Model\PlayerRepository;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{
    public ClientEntityManager $clientEntityManager;
    public OrderRepository $orderRepository;
    public SqlConnector $sqlConnector;
    public OrderEntityManager $orderEntityManager;

    public function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();
        $this->clientEntityManager = new ClientEntityManager();
        $this->playerRepository = new PlayerRepository();
        $this->orderRepository = new OrderRepository();
        $this->orderEntityManager = new OrderEntityManager();

        $ClientDTO = new ClientDTO();
        $ClientDTO->username = 'TEST';
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->password = '$2y$10$hfMft79lTEeHSDGsMf91s.iJcUTgVoIHnUQVGfxleSTXARmpr7nN6';

        $this->clientEntityManager->saveCredentials($ClientDTO);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testGetOrderInformation(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $_POST['first_name'] = 'TEST-FIRST';
        $_POST['last_name'] = 'TEST-LAST';
        $_POST['address'] = 'TEST-ADDRESS';
        $_POST['city'] = 'TEST-CITY';
        $_POST['zip'] = '1337';
        $_POST['payment'] = 'TEST-PAYMENT';
        $_POST['delivery'] = 'TEST-DELIVERY';

        $billingDTO = $this->orderRepository->getOrderInformation();

        self::assertSame('TEST-FIRST', $billingDTO->firstName);
        self::assertSame('TEST-LAST', $billingDTO->lastName);
        self::assertSame('1337', $billingDTO->zip);
        self::assertSame('TEST-CITY', $billingDTO->city);
        self::assertSame('TEST-DELIVERY', $billingDTO->delivery);
        self::assertSame('TEST-PAYMENT', $billingDTO->paymentMethod);
    }

    public function testGetOrderId(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $orderDTO = new OrderDTO();
        $orderDTO->email = 'TEST@TEST.com';
        $orderDTO->firstName = 'TEST-FIRST';
        $orderDTO->lastName = 'TEST-LAST';
        $orderDTO->zip = '1337';
        $orderDTO->city = 'TEST-CITY';
        $orderDTO->address = 'TEST-ADDRESS';
        $orderDTO->paymentMethod = 'TEST-PAYMENT';
        $orderDTO->delivery = 'TEST-DELIVERY';


        $this->orderEntityManager->saveOrder($orderDTO);

        $orderID = $this->orderRepository->getOrderId();


        self::assertIsInt($orderID);
        self::assertNotEmpty($orderID);
    }


    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM orders;", []);
        $connector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $connector->closeConnection();
        parent::tearDown();
    }

}