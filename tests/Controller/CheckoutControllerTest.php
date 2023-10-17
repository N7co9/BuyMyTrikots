<?php

namespace Controller;

use App\Controller\CheckoutController;
use App\Controller\ClientLoginController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Core\DTO\ClientDTO;
use App\Core\Redirect\RedirectSpy;
use App\Core\SQL\SqlConnector;
use App\Model\ClientEntityManager;
use PHPUnit\Framework\TestCase;

class CheckoutControllerTest extends TestCase
{
    public ClientLoginController $clientLoginController;
    public ClientEntityManager $clientEntityManager;

    protected function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->clientEntityManager = new ClientEntityManager();

        $this->container = $containerBuilder;
        $this->construct = new CheckoutController($this->container);

        $clientDTO = new ClientDTO();
        $clientDTO->email = 'TEST@TEST.com';
        $clientDTO->password = '$2y$10$d9nKafUjEIkwJGRTM0pUcec9papz3UojboRwnzV10yomN0qM3mWha';
        $this->clientEntityManager->saveCredentials($clientDTO);


        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';
        self::assertSame('checkout.twig', $this->construct->dataConstruct()->getTpl() );
    }

    public function tearDown(): void
    {
        $this->sqlConnector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $this->sqlConnector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();

        parent::tearDown();
    }
}