<?php

namespace Model;

use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\UserRegistration\Persistence\UserEntityManager;
use App\Components\UserSession\Persistence\UserCredentialsRepository;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\SQL\SqlConnector;
use PHPUnit\Framework\TestCase;

class ClientRepositoryTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public UserRepository $userRepository;
    public BasketRepository $basketRepository;
    public UserEntityManager $userEntityManager;
    public UserCredentialsRepository $credentialsRepository;

    public function setUp(): void
    {
        $container = new Container();
        $provider = new DependencyProvider();
        $provider->provide($container);

        $this->userRepository = $container->get(UserRepository::class);
        $this->sqlConnector = $container->get(SqlConnector::class);
        $this->basketRepository = $container->get(BasketRepository::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
        $this->credentialsRepository = $container->get(UserCredentialsRepository::class);

        $ClientDTO = new ClientDTO();
        $ClientDTO->username = 'TEST';
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->password = '$2y$10$hfMft79lTEeHSDGsMf91s.iJcUTgVoIHnUQVGfxleSTXARmpr7nN6';

        $this->userEntityManager->saveCredentials($ClientDTO);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testFindByMail(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';
        $ClientDTO = $this->userRepository->findByMail($_SESSION['mail']);


        self::assertInstanceOf(ClientDTO::class, $ClientDTO);
        self::assertSame('TEST', $ClientDTO->username);
        self::assertSame('TEST@TEST.com', $ClientDTO->email);
        self::assertSame('$2y$10$hfMft79lTEeHSDGsMf91s.iJcUTgVoIHnUQVGfxleSTXARmpr7nN6', $ClientDTO->password);
    }

    public function testGetUserID(): void
    {
        $id = $this->userRepository->getUserID('TEST@TEST.com');

        self::assertIsInt($id);
        self::assertNotEmpty($id);
    }

    public function testGetUserIDInvalid(): void
    {
        $id = $this->userRepository->getUserID('INVALID');

        self::assertNull($id);
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