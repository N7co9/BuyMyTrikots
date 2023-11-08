<?php

namespace Model;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\Repository\ClientRepository;
use App\Global\Persistence\SQL\SqlConnector;
use App\User\Components\Basket\Business\DTO\BasketDTO;
use App\User\Components\Basket\Persistence\Repository\BasketRepository;
use App\User\Components\Registration\Persistence\Entity\ClientEntityManager;
use PHPUnit\Framework\TestCase;

class BasketRepositoryTest extends TestCase
{
    private BasketRepository $basketRepository;
    private ClientEntityManager $clientEntityManager;
    private ClientRepository $clientRepository;

    public function setUp(): void
    {
        $this->basketRepository = new BasketRepository();
        $this->clientRepository = new ClientRepository();
        $this->clientEntityManager = new ClientEntityManager();

        $ClientDTO = new ClientDTO();
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->username = 'TEST';
        $ClientDTO->password = 'QWERTZ';
        $this->clientEntityManager->saveCredentials($ClientDTO);

        parent::setUp();
    }

    public function testGetBasketInfoOneItem(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));

        $basket = $this->basketRepository->getBasketInfo();

        self::assertInstanceOf(BasketDTO::class, $basket[0]);
        self::assertSame('Cristiano Ronaldo Trikot', $basket[0]->name);
        self::assertSame('44', $basket[0]->id);
        self::assertSame('1', $basket[0]->quantity);
    }

    public function testGetBasketInfoMultipleItems(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));
        $this->clientEntityManager->addToBasket('334', $this->clientRepository->getUserID($_SESSION['mail']));


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

        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));

        $quantity = $this->basketRepository->getItemQuantity(44);

        self::assertSame('1', $quantity[0]['quantity']);
    }

    public function testGetBasketTotal(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));

        $total = $this->basketRepository->getBasketTotal();

        self::assertSame('29.99', $total);
    }


    public function testGetBasketTotalQuantity(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';

        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));
        $this->clientEntityManager->addToBasket('44', $this->clientRepository->getUserID($_SESSION['mail']));


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