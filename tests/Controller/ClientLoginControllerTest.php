<?php

namespace Controller;

use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Redirect\Redirect;
use App\Global\Business\Redirect\RedirectSpy;
use App\Global\Persistence\SQL\SqlConnector;
use App\User\Components\Login\Communication\Controller\ClientLoginController;
use App\User\Components\Registration\Persistence\Entity\ClientEntityManager;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class ClientLoginControllerTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public RedirectSpy $redirectSpy;
    public ClientLoginController $clientLoginController;
    public ClientEntityManager $clientEntityManager;
    protected function setUp(): void
    {
        $this->sqlconnector = new SqlConnector();
        $this->redirectSpy = new RedirectSpy();

        $container = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($container);
        $container->set(Redirect::class, $this->redirectSpy);

        $this->clientEntityManager = new ClientEntityManager();

        $clientDTO = new ClientDTO();
        $clientDTO->email = 'TEST@TEST.com';
        $clientDTO->password = '$2y$10$d9nKafUjEIkwJGRTM0pUcec9papz3UojboRwnzV10yomN0qM3mWha';
        $this->clientEntityManager->saveCredentials($clientDTO);

        $this->clientLoginController = new ClientLoginController($container);
        parent::setUp();
    }
    public function testDataConstructValid(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['password'] = 'Xyz12345*';

        $this->clientLoginController->dataConstruct();

        self::assertSame('TEST@TEST.com', $_SESSION['mail']);
        self::assertSame('?page=shop', $this->clientLoginController->redirect->location);
        self::assertSame(['feedback' => 'success'], $this->clientLoginController->dataConstruct()->getParameters());
        assertSame('login.twig', $this->clientLoginController->dataConstruct()->getTpl());
    }
    public function testDataConstructInvalidRequestMethod(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';


        assertSame(['feedback' => ''], $this->clientLoginController->dataConstruct()->getParameters());
    }

    public function testDataConstructInvalidCombination(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->clientLoginController->dataConstruct();

        unset($_POST['mail'], $_POST['password']);


        assertSame(['feedback' => 'not a valid combination'], $this->clientLoginController->dataConstruct()->getParameters());
    }


    public function tearDown(): void
    {
        $this->sqlConnector = new SqlConnector();
        $this->sqlConnector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $this->sqlConnector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();

        parent::tearDown();
    }

}