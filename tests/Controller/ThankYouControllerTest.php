<?php

namespace Controller;

use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\DTO\OrderDTO;
use App\Global\Persistence\Repository\ClientRepository;
use App\Global\Persistence\Repository\OrderRepository;
use App\Global\Persistence\SQL\SqlConnector;
use App\User\Components\Basket\Persistence\Repository\BasketRepository;
use App\User\Components\Order\Persistence\Entity\OrderEntityManager;
use App\User\Components\Registration\Persistence\Entity\ClientEntityManager;
use App\User\Components\ThankYou\Communication\Controller\ThankYouController;
use PHPUnit\Framework\TestCase;

class ThankYouControllerTest extends TestCase
{
    public ThankYouController $thankYouController;
    public SqlConnector $sqlConnector;
    public ClientRepository $clientRepository;
    public BasketRepository $basketRepository;
    public ClientEntityManager $clientEntityManager;
    public OrderEntityManager $orderEntityManager;
    public OrderRepository $orderRepository;

    public function setUp(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

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

        $this->clientEntityManager->saveCredentials($ClientDTO);


        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID('TEST@TEST.com'));

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->construct = new ThankYouController($containerBuilder);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testDataConstruct(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        self::assertIsInt($this->construct->dataConstruct()->getParameters()['orderID']);
        self::assertIsArray($this->construct->dataConstruct()->getParameters()['basket']);
        self::assertEmpty($this->construct->dataConstruct()->getParameters()['basket']);
        self::assertInstanceOf(OrderDTO::class, $this->construct->dataConstruct()->getParameters()['order']);
        self::assertSame('thankyou.twig', $this->construct->dataConstruct()->getTpl());

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