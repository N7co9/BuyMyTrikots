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
        $_SESSION = [];
        $_POST = [];
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
    /**
     * @dataProvider passwordValidationProvider
     */
    public function testPasswordValidation(string $password, string $expectedErrorMessage): void
    {
        $userDTO = new ClientDTO();
        $userDTO->email = 'TEST@TEST.com';
        $userDTO->username = 'TEST';
        $userDTO->password = $password;

        $errorArray = $this->clientValidator->validate($userDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame($expectedErrorMessage, $errorArray[0]->message);
    }

    public static function passwordValidationProvider(): array
    {
        return [
            'Empty password' => ['', 'Oops, your password doesn\'t look right!'],
            'No uppercase' => ['xyz12345**', 'Oops, your password doesn\'t look right!'],
            'No lowercase' => ['XYZ12345*', 'Oops, your password doesn\'t look right!'],
            'No digit' => ['XyzOneTwoThreeFourFive*', 'Oops, your password doesn\'t look right!'],
            'No special character' => ['XyzOneTwoThreeFourFive', 'Oops, your password doesn\'t look right!'],
            'Too short' => ['Xy23*', 'Oops, your password doesn\'t look right!'],
            'Too Short 6' => ['Xyz12*', 'Oops, your password doesn\'t look right!']
        ];
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