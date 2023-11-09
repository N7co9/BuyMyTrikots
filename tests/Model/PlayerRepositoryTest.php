<?php

namespace Model;

use App\Components\Basket\Persistence\Repository\BasketRepository;
use App\Components\Homepage\Persistence\Repository\PlayerRepository;
use App\Components\UserRegistration\Persistence\UserEntityManager;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\DTO\PlayerDTO;
use App\Global\Business\Mapper\ApiMapper;
use App\Global\Business\Mapper\ClientMapper;
use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;
use App\Global\Persistence\SQL\SqlConnector;
use App\Global\Presentation\Session\SessionHandler;
use PHPUnit\Framework\TestCase;

class PlayerRepositoryTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public UserRepository $userRepository;
    public BasketRepository $basketRepository;
    public UserEntityManager $userEntityManager;
    public PlayerRepository $playerRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(new ClientMapper(), new SqlConnector());
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository($this->userRepository, new ApiMapper(), new SqlConnector(), new ApiCache(new ApiHandling()), new SessionHandler());
        $this->userEntityManager = new UserEntityManager(new SqlConnector());
        $this->playerRepository = new PlayerRepository(new ApiHandling(), new ApiMapper(), new ApiCache(new ApiHandling()));

        $ClientDTO = new ClientDTO();
        $ClientDTO->username = 'TEST';
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->password = '$2y$10$hfMft79lTEeHSDGsMf91s.iJcUTgVoIHnUQVGfxleSTXARmpr7nN6';

        $this->userEntityManager->saveCredentials($ClientDTO);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testGetPlayers(): void
    {
        $arrayOfPlayerDTOs = $this->playerRepository->getPlayers('3');

        self::assertIsArray($arrayOfPlayerDTOs);
        self::assertNotEmpty($arrayOfPlayerDTOs);
        self::assertInstanceOf(PlayerDTO::class, $arrayOfPlayerDTOs[0]);

        self::assertSame('Niklas Lomb', $arrayOfPlayerDTOs[0]->name);
        self::assertSame('165', $arrayOfPlayerDTOs[0]->id);
        self::assertSame('Germany', $arrayOfPlayerDTOs[0]->nationality);
        self::assertSame('Bayer 04 Leverkusen', $arrayOfPlayerDTOs[0]->clubName);
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