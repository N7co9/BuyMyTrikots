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
        $this->billingValidator = new BillingValidator($this->redirectSpy);
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
    public function testValidateMultipleExceptions(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = '';
        $billingDTO->lastName = '';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertInstanceOf(ErrorDTO::class, $errorArray[1]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[1]->message);

    }
    public function testValidateLastNameExceptionEmpty(): void
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
    public function testValidateLastNameExceptionTooShort(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = 'ab';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateLastNameExceptionTooShort1(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = 'a';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateLastNameExceptionTooLong30(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateLastNameExceptionCaret(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = '1abc DEF- ';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateLastNameExceptionTooLong(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvw';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateLastNameExceptionCharacters(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-FIRST';
        $billingDTO->lastName = 'CharacterExcepti!!on1111';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your last name doesn\'t look right!', $errorArray[0]->message);
    }

    public function testValidateFirstNameExceptionEmpty(): void
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
    public function testValidateFirstNameExceptionTooShort(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'ab';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateFirstNameExceptionTooShort1(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'a';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateFirstNameExceptionTooLong(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvw';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateFirstNameExceptionTooLong30(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateFirstNameExceptionCharacter(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'Characters!!111';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateFirstNameExceptionCaret(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = '1abc DEF- ';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your first name doesn\'t look right!', $errorArray[0]->message);
    }

    public function testValidateCityExceptionEmpty(): void
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
    public function testValidateCityExceptionTooShort(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'ab';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateCityExceptionTooLong(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvw';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateCityExceptionTooLong20(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'aaaaaaaaaaaaaaaaaaaa';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateCityExceptionCharacters(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = '###!!!LOL123';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateCityExceptionCaret(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = '1abc DEF- ';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateCityExceptionDollar(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'New York123';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your City doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateZipExceptionTooShort(): void
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
    public function testValidateZipExceptionTooLong(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345678';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';

        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Zip-Code doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateZipExceptionCharacters(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = 'abcde';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'TEST-ADDRESS';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';

        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Zip-Code doesn\'t look right!', $errorArray[0]->message);
    }

    public function testValidateAddressExceptionTooShort(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'aa';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressExceptionTooShort1(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'a';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressExceptionTooLong(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvw';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressExceptionTooLong20(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'aaaaaaaaaaaaaaaaaaaa';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressExceptionCharacters(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = '1234ahsj!!';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressExceptionDollar(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = 'ValidStart123';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }
    public function testValidateAddressExceptionCaret(): void
    {
        $_POST['first_name'] = '';
        $billingDTO = new OrderDTO();

        $billingDTO->zip = '12345';
        $billingDTO->city = 'TEST-CITY';
        $billingDTO->address = '1abc DEF- ';
        $billingDTO->firstName = 'TEST-LAST';
        $billingDTO->lastName = 'TEST-LAST';


        $errorArray = $this->billingValidator->validate($billingDTO);

        self::assertInstanceOf(ErrorDTO::class, $errorArray[0]);
        self::assertSame('Oops, your Address doesn\'t look right!', $errorArray[0]->message);
    }


    public function testRedirectIfValid() : void
    {
        $_POST['delivery'] = '';
        $array = [];

        $this->billingValidator->redirectIfValid($array);

        self::assertSame('?page=order-overview', $this->billingValidator->redirect->location);
    }
    public function testRedirectIfValidExceptionNoPost() : void
    {
        $array = [];

        $this->billingValidator->redirectIfValid($array);

        self::assertEmpty( $this->billingValidator->redirect->location);
    }
    public function testRedirectIfValidExceptionErrorArrayNotEmpty() : void
    {
        $_POST['delivery'] = '';
        $array = [new ErrorDTO('ERROR')];

        $this->billingValidator->redirectIfValid($array);

        self::assertEmpty( $this->billingValidator->redirect->location);
    }
    public function testTrimWhiteSpaces() : void
    {
        $trim = '    leading spaces';
        $trim = $this->billingValidator->trim($trim);

        self::assertSame('leading spaces', $trim);
    }

    public function tearDown(): void
    {
        unset ($_POST['delivery']);
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

}