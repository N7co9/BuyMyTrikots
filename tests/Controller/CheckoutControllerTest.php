<?php

namespace Controller;

use App\Components\Checkout\Business\Validation\BillingValidator;
use App\Components\Checkout\Communication\Controller\CheckoutController;
use App\Components\User\Communication\Controller\UserLoginController;
use App\Components\User\Persistence\Entity\UserEntityManager;
use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Redirect\RedirectSpy;
use App\Global\Persistence\SQL\SqlConnector;
use PHPUnit\Framework\TestCase;

class CheckoutControllerTest extends TestCase
{
    public UserLoginController $clientLoginController;
    public UserEntityManager $clientEntityManager;
    public RedirectSpy $redirectSpy;

    protected function setUp(): void
    {
        $_SESSION = [];
        $_POST = [];
        $this->sqlConnector = new SqlConnector();
        $this->redirectSpy = new RedirectSpy();

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->clientEntityManager = new UserEntityManager();

        $container = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($container);

        $container->set(BillingValidator::class, new BillingValidator($this->redirectSpy));

        $this->checkoutController = new CheckoutController($container);

        $clientDTO = new ClientDTO();
        $clientDTO->email = 'TEST@TEST.com';
        $clientDTO->password = '$2y$10$d9nKafUjEIkwJGRTM0pUcec9papz3UojboRwnzV10yomN0qM3mWha';
        $this->clientEntityManager->saveCredentials($clientDTO);


        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $_SESSION['mail'] = 'TEST@TEST.com';
        $_POST['delivery'] = 'set';
        $this->checkoutController->errorDTOList = [];
        $this->checkoutController->dataConstruct();

        $location = $this->checkoutController->billingValidator->redirect->location;

        self::assertSame('?page=order-overview', $location);
        self::assertSame('checkout.twig', $this->checkoutController->dataConstruct()->getTpl() );
        self::assertIsArray($this->checkoutController->dataConstruct()->getParameters()['errors']);
        self::assertSame('TEST@TEST.com', $this->checkoutController->dataConstruct()->getParameters()['values']->email);
        self::assertIsArray($this->checkoutController->dataConstruct()->getParameters()['basket']);
        self::assertSame('0', $this->checkoutController->dataConstruct()->getParameters()['total']);

    }

    public function tearDown(): void
    {
        $this->sqlConnector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $this->sqlConnector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();

        parent::tearDown();
    }
}