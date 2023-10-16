<?php

namespace Controller;

use App\Controller\ClientLoginController;
use App\Controller\ClientRegistrationController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Core\DTO\ClientDTO;
use App\Core\Redirect\RedirectSpy;
use App\Core\SQL\SqlConnector;
use App\Model\ClientEntityManager;
use PhpParser\Lexer\TokenEmulator\NumericLiteralSeparatorEmulator;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class ClientLoginControllerTest extends TestCase
{
    public RedirectSpy $redirectSpy;
    public ClientLoginController $clientLoginController;
    public ClientEntityManager $clientEntityManager;
    protected function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->clientEntityManager = new ClientEntityManager();
        $this->redirectSpy = new RedirectSpy();

        $this->container = $containerBuilder;
        $this->construct = new ClientLoginController($this->container);

        $clientDTO = new ClientDTO();
        $clientDTO->email = 'TEST@TEST.com';
        $clientDTO->password = '$2y$10$d9nKafUjEIkwJGRTM0pUcec9papz3UojboRwnzV10yomN0qM3mWha';
        $this->clientEntityManager->saveCredentials($clientDTO);



        parent::setUp();
    }
    public function testDataConstructValid(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['password'] = 'Xyz12345*';

        $this->construct->dataConstruct();

        self::assertContains('http://localhost:8000/?page=shop', $this->construct->redirectSpy->capturedHeaders);
        self::assertSame(['feedback' => 'success'], $this->construct->dataConstruct()->getParameters());
        assertSame('login.twig', $this->construct->dataConstruct()->getTpl());
    }
    public function testDataConstructInvalidRequestMethod(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';


        assertSame(['feedback' => ''], $this->construct->dataConstruct()->getParameters());
    }

    public function testDataConstructInvalidCombination(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->construct->dataConstruct();

        unset($_POST['mail']);
        unset($_POST['password']);


        assertSame(['feedback' => 'not a valid combination'], $this->construct->dataConstruct()->getParameters());
    }


    public function tearDown(): void
    {
        $this->sqlConnector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $this->sqlConnector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();

        parent::tearDown();
    }

}