<?php

namespace Core\Basket;

use App\Components\Basket\Business\DTO\BasketDTO;
use App\Components\Basket\Business\Manipulation\BasketManipulator;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\User\Persistence\Entity\UserEntityManager;
use App\Components\User\Persistence\Repository\UserRepository;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\SQL\SqlConnector;
use PHPUnit\Framework\TestCase;

class BasketManipulatorTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public UserRepository $clientRepository;
    public BasketRepository $basketRepository;
    public UserEntityManager $clientEntityManager;
    public BasketManipulator $basketManipulator;
    public function setUp(): void
    {
        $this->clientRepository = new UserRepository();
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository();
        $this->clientEntityManager = new UserEntityManager();
        $this->basketManipulator = new BasketManipulator();

        $ClientDTO = new ClientDTO();
        $ClientDTO->username = 'TEST';
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->password = 'QWERTZ';

        $this->clientEntityManager->saveCredentials($ClientDTO);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testAddItemToBasket() : void
    {
        $_GET['id'] = '44';
        $_SESSION['mail'] = 'TEST@TEST.com';
        $this->basketManipulator->addItemToBasket();

        $basket = $this->basketRepository->getBasketInfo();

        self::assertInstanceOf(BasketDTO::class, $basket[0]);
        self::assertSame('Cristiano Ronaldo Trikot', $basket[0]->name);
    }

    public function testRemoveItemFromBasket() : void
    {
        $_GET['id'] = '44';
        $_SESSION['mail'] = 'TEST@TEST.com';
        $this->basketManipulator->addItemToBasket();

        $this->basketManipulator->removeItemFromBasket();

        $basket = $this->basketRepository->getBasketInfo();

        self::assertEmpty($basket);
    }

        public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $connector->closeConnection();
        parent::tearDown();
    }
}