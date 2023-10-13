<?php

namespace Model;

use App\Core\DTO\ClientDTO;
use App\Core\DTO\PlayerDTO;
use App\Core\SQL\SqlConnector;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;
use App\Model\OrderEntityManager;
use App\Model\PlayerRepository;
use PHPUnit\Framework\TestCase;

class PlayerRepositoryTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public ClientRepository $clientRepository;
    public BasketRepository $basketRepository;
    public ClientEntityManager $clientEntityManager;
    public PlayerRepository $playerRepository;

    public function setUp(): void
    {
        $this->clientRepository = new ClientRepository();
        $this->sqlConnector = new SqlConnector();
        $this->basketRepository = new BasketRepository();
        $this->clientEntityManager = new ClientEntityManager();
        $this->playerRepository = new PlayerRepository();

        $ClientDTO = new ClientDTO();
        $ClientDTO->username = 'TEST';
        $ClientDTO->email = 'TEST@TEST.com';
        $ClientDTO->password = '$2y$10$hfMft79lTEeHSDGsMf91s.iJcUTgVoIHnUQVGfxleSTXARmpr7nN6';

        $this->clientEntityManager->saveCredentials($ClientDTO);
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