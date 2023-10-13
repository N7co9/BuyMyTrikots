<?php

namespace Core\Validation;

use App\Core\DTO\ClientDTO;
use App\Core\DTO\ErrorDTO;
use App\Core\Validation\ClientValidator;
use PHPUnit\Framework\TestCase;

class ClientValidatorTest extends TestCase
{
    public ClientValidator $clientValidator;
    public function setUp(): void
    {
        $this->clientValidator = new ClientValidator();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testValidateSuccessful(): void
    {
        $userDTO = new ClientDTO();

        $userDTO->email = 'TEST@TEST.com';
        $userDTO->username = 'TEST';
        $userDTO->password = 'Xyz12345*';

        $errorArray = $this->clientValidator->validate($userDTO);

        self::assertEmpty($errorArray);
    }
    public function testValidateExceptionPassword() : void
    {
        $userDTO = new ClientDTO();

        $userDTO->email = 'TEST@TEST.com';
        $userDTO->username = 'TEST';
        $userDTO->password = 'INVALID*';

        $errorArray = $this->clientValidator->validate($userDTO);


        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your password doesn\'t look right!', $errorArray[0]->message);
    }

    public function testValidateExceptionUsername() : void
    {
        $userDTO = new ClientDTO();

        $userDTO->email = 'TEST@TEST.com';
        $userDTO->username = '';
        $userDTO->password = 'Xyz12345*';

        $errorArray = $this->clientValidator->validate($userDTO);


        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your name doesn\'t look right', $errorArray[0]->message);
    }
    public function testValidateExceptionEmail() : void
    {
        $userDTO = new ClientDTO();

        $userDTO->email = 'INVALID';
        $userDTO->username = 'TEST';
        $userDTO->password = 'Xyz12345*';

        $errorArray = $this->clientValidator->validate($userDTO);


        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your email doesn\'t look right', $errorArray[0]->message);
    }
}