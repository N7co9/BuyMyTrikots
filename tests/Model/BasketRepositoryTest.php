<?php

namespace Model;

use App\Components\Basket\Persistence\Entity\BasketEntityManager;
use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\UserRegistration\Persistence\UserEntityManager;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\BasketDTO;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\SQL\SqlConnector;
use PHPUnit\Framework\TestCase;

class BasketRepositoryTest extends TestCase
{
    private BasketRepository $basketRepository;
    private UserEntityManager $userEntityManager;
    private UserRepository $userRepository;
    private BasketEntityManager $basketEntityManager;

    public function setUp(): void
    {
        $container = new Container();
        $provider = new DependencyProvider();
        $provider->provide($container);

        $this->basketRepository = $container->get(BasketRepository::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
        $this->basketEntityManager = $container->get(BasketEntityManager::class);

        $ClientDTO = new ClientDTO();
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->username = 'TEST';
        $ClientDTO->password = 'QWERTZ';
        $this->userEntityManager->saveCredentials($ClientDTO);

        parent::setUp();
    }

    public function testGetBasketInfoOneItem(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->basketEntityManager->addToBasket('44', $this->userRepository->getUserID($_SESSION['mail']));

        $basket = $this->basketRepository->getBasketInfo();

        self::assertInstanceOf(BasketDTO::class, $basket[0]);
        self::assertSame('Cristiano Ronaldo Trikot', $basket[0]->name);
        self::assertSame('44', $basket[0]->id);
        self::assertSame('1', $basket[0]->quantity);
    }

    public function testGetBasketInfoMultipleItems(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->basketEntityManager->addToBasket('44', $this->userRepository->getUserID($_SESSION['mail']));
        $this->basketEntityManager->addToBasket('334', $this->userRepository->getUserID($_SESSION['mail']));


        $basket = $this->basketRepository->getBasketInfo();

        self::assertInstanceOf(BasketDTO::class, $basket[0]);
        self::assertSame('Cristiano Ronaldo Trikot', $basket[0]->name);
        self::assertSame('44', $basket[0]->id);
        self::assertSame('1', $basket[0]->quantity);
        self::assertSame('Gregor Kobel Trikot', $basket[1]->name);
        self::assertSame('334', $basket[1]->id);
        self::assertSame('1', $basket[1]->quantity);
    }

    public function testGetItemQuantity(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->basketEntityManager->addToBasket('44', $this->userRepository->getUserID($_SESSION['mail']));

        $quantity = $this->basketRepository->getItemQuantity(44);

        self::assertSame('1', $quantity[0]['quantity']);
    }

    public function testGetBasketTotal(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->basketEntityManager->addToBasket('44', $this->userRepository->getUserID($_SESSION['mail']));

        $total = $this->basketRepository->getBasketTotal();

        self::assertSame('29.99', $total);
    }


    public function testGetBasketTotalQuantity(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->basketEntityManager->addToBasket('44', $this->userRepository->getUserID($_SESSION['mail']));
        $this->basketEntityManager->addToBasket('44', $this->userRepository->getUserID($_SESSION['mail']));


        $total = $this->basketRepository->getBasketTotal();

        self::assertSame('59.98', $total);
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