<?php

namespace Controller;

use App\Controller\CheckoutController;
use App\Controller\ClientLoginController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Core\DTO\ClientDTO;
use App\Core\Redirect\RedirectSpy;
use App\Core\SQL\SqlConnector;
use App\Core\Validation\BillingValidator;
use App\Model\ClientEntityManager;
use PHPUnit\Framework\TestCase;

class CheckoutControllerTest extends TestCase
{
    public ClientLoginController $clientLoginController;
    public ClientEntityManager $clientEntityManager;
    public RedirectSpy $redirectSpy;

    protected function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();
        $this->redirectSpy = new RedirectSpy();

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->clientEntityManager = new ClientEntityManager();

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
        $_POST['delivery'] = 'set';
        $this->checkoutController->errorDTOList = [];
        $this->checkoutController->dataConstruct();

        $location = $this->checkoutController->billingValidator->redirect->location;

        self::assertSame('?page=order-overview', $location);
        $_SESSION['mail'] = 'TEST@TEST.com';
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