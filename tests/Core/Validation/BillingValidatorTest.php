<?php

namespace Core\Validation;

use App\Core\DTO\ErrorDTO;
use App\Core\DTO\OrderDTO;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;
use App\Core\Validation\BillingValidator;
use PHPUnit\Framework\TestCase;

class BillingValidatorTest extends TestCase
{
    public BillingValidator $billingValidator;
    public function setUp(): void
    {
        $this->redirectSpy = new RedirectSpy();
        $this->billingValidator = new BillingValidator(new Redirect($this->redirectSpy));
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testValidate(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertEmpty($errorArray);
    }
    public function testValidateLastNameException(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = '';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }

    public function testValidateFirstNameException(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = '';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressException(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = '';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateCityException(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = '';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateZipException(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '1';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';

        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Zip-Code doesn\'t look right!', $errorArray[0]->message);
    }

    public function testRedirectIfValid() : void
    {
        $_POST['delivery'] = '';
        $array = [];

        $this->billingValidator->redirectIfValid($array);

        self::assertContains('http://localhost:8000/?page=order-overview', $this->redirectSpy->capturedHeaders);
    }
    public function testRedirectIfValidExceptionNoPost() : void
    {
        $array = [];

        $this->billingValidator->redirectIfValid($array);

        self::assertEmpty( $this->redirectSpy->capturedHeaders);
    }
    public function testRedirectIfValidExceptionErrorArrayNotEmpty() : void
    {
        $_POST['delivery'] = '';
        $array = [new ErrorDTO('ERROR')];

        $this->billingValidator->redirectIfValid($array);

        self::assertEmpty( $this->redirectSpy->capturedHeaders);
    }

    public function tearDown(): void
    {
        unset ($_POST['delivery']);
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}