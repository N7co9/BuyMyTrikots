<?php

namespace Model;

use App\Core\DTO\ClientDTO;
use App\Core\DTO\OrderDTO;
use App\Core\SQL\SqlConnector;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;
use App\Model\OrderEntityManager;
use App\Model\OrderRepository;
use PHPUnit\Framework\TestCase;

class OrderEntityManagerTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public ClientRepository $clientRepository;
    public BasketRepository $basketRepository;
    public ClientEntityManager $clientEntityManager;
    public OrderEntityManager $orderEntityManager;
    public OrderRepository $orderRepository;

    public function setUp(): void
    {
        $this->clientRepository = new ClientRepository();
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository();
        $this->clientEntityManager = new ClientEntityManager();
        $this->orderEntityManager = new OrderEntityManager();
        $this->orderRepository = new OrderRepository();

        $ClientDTO = new ClientDTO();
        $ClientDTO->username = 'TEST';
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->password = '$2y$10$hfMft79lTEeHSDGsMf91s.iJcUTgVoIHnUQVGfxleSTXARmpr7nN6';

        $this->clientEntityManager->saveCredentials($ClientDTO);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testSaveOrderValid() : void
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

        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));

        $result = $this->orderEntityManager->saveOrder($orderDTO);

        $sqlSelectArray = $this->sqlConnector->executeSelectQuery('SELECT * FROM orders', []);

        self::assertNotEmpty($result);
        self::assertSame('{"id": "44", "quantity": "1"}', $sqlSelectArray[0]['items']);
        self::assertSame('TEST-FIRST', $sqlSelectArray[0]['firstName']);
        self::assertSame('TEST-LAST', $sqlSelectArray[0]['lastName']);
        self::assertSame('1337', $sqlSelectArray[0]['zip']);
        self::assertSame('TEST-CITY', $sqlSelectArray[0]['city']);
        self::assertSame('TEST-DELIVERY', $sqlSelectArray[0]['delivery']);
        self::assertSame('TEST-PAYMENT', $sqlSelectArray[0]['payment']);
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