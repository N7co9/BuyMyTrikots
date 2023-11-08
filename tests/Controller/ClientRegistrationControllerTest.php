<?php

namespace Controller;

use App\Global\Business\Dependency\Container;
use App\Global\Business\Dependency\DependencyProvider;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\Repository\ClientRepository;
use App\Global\Persistence\SQL\SqlConnector;
use App\User\Components\Registration\Communication\Controller\ClientRegistrationController;
use App\User\Components\Registration\Persistence\Entity\ClientEntityManager;
use PHPUnit\Framework\TestCase;

class ClientRegistrationControllerTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public ClientEntityManager $entityManager;
    public ClientRepository $clientRepository;

    protected function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();

        $this->clientRepository = new ClientRepository();

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new ClientRegistrationController($this->container);
        $this->entityManager = new ClientEntityManager();

        parent::setUp();
    }

    public function testDataConstructValid() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TESTING';
        $_POST['mail'] = 'T1EST@TEST.com';
        $_POST['password'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        $verifyNewClient = $this->clientRepository->findByMail('T1EST@TEST.com');


        // since the Input is Valid, the Registration Controller will reset the vName & vMail
        // values to '' -> if not Valid the Name and Mail values would persist.

        self::assertSame('TESTING', $verifyNewClient->username);
        self::assertSame('registration.twig', $output->getTpl());
        self::assertInstanceOf(ClientDTO::class, $output->getParameters()['user']);
        self::assertSame('', $output->getParameters()['vName']);
        self::assertSame('', $output->getParameters()['vMail']);
        self::assertSame('Success. Welcome abroad!', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidName() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['password'] = 'Xyz12345*';


        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidEmail() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['password'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidPasswort() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['password'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidNameAndInvalidEmail() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['password'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][1]->message);
    }
    public function testDataConstructInvalidNameAndInvalidPasswort() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['password'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][1]->message);
    }
    public function testDataConstructInvalidEmailAndInvalidPasswort() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['password'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][1]->message);
    }

    public function testDataConstructAllInvalid() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['password'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][1]->message);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][2]->message);
    }
    public function testDataConstructEmailNotUnique() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['password'] = 'Xyz12345*';

        $putEmailInSystem = new ClientDTO();
        $putEmailInSystem->email = 'TEST@TEST.com';
        $this->entityManager->saveCredentials($putEmailInSystem);


        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email is already registered!', $output->getParameters()['errors'][0]->message);
    }
    public function tearDown(): void
    {
        $this->sqlConnector->executeDeleteQuery("DELETE FROM orders;", []);
        $this->sqlConnector->executeDeleteQuery("DELETE FROM user_baskets;", []);
        $this->sqlConnector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();
        parent::tearDown();
    }
}