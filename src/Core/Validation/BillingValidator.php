<?php

namespace App\Core\Validation;

use App\Core\DTO\ErrorDTO;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectInterface;
use App\Core\Redirect\RedirectSpy;

class BillingValidator
{
    public RedirectInterface $redirect;

    public function __construct(RedirectInterface $redirect)
    {
        $this->redirect = $redirect;
    }

    public function validate($billingInformation): array
    {
        $errorDTOList = [];
        if (isset($_POST['first_name'])) {
            $this->validateCity($billingInformation->city, $errorDTOList);
            $this->validateZip($billingInformation->zip, $errorDTOList);
            $this->validateAddress($billingInformation->address, $errorDTOList);
            $this->validateLastName($billingInformation->lastName, $errorDTOList);
            $this->validateFirstName($billingInformation->firstName, $errorDTOList);
        }
        return $errorDTOList;
    }

    public function redirectIfValid($array): void
    {
        if (isset($_POST['delivery']) && empty($array)) {
            $this->redirect->to('?page=order-overview');
        }
    }

    private function validateFirstName($firstName, &$errorDTOList): void
    {
        $firstName = $this->trim($firstName);
        if (strlen($firstName) >= 30 || strlen($firstName) <= 2 ||
            !preg_match('/^[a-zA-Z\s-]+$/', $firstName)) {
            $errorDTOList[] = new ErrorDTO('Oops, your first name doesn\'t look right!');
        }
    }

    private function validateLastName($lastName, &$errorDTOList): void
    {
        $lastName = $this->trim($lastName);
        if (strlen($lastName) >= 30 || strlen($lastName) <= 2 ||
            !preg_match('/^[a-zA-Z\s-]+$/', $lastName)) {
            $errorDTOList[] = new ErrorDTO('Oops, your last name doesn\'t look right!');
        }
    }

    private function validateCity($city, &$errorDTOList): void
    {
        $city = $this->trim($city);
        if (strlen($city) >= 20 || strlen($city) <= 2 ||
            !preg_match('/^[a-zA-Z\s-]+$/', $city)) {
            $errorDTOList[] = new ErrorDTO('Oops, your City doesn\'t look right!');
        }
    }

    private function validateZip($zip, &$errorDTOList): void
    {
        $zip = $this->trim($zip);
        if (!preg_match('/^\d{4,6}$/', $zip)) {
            $errorDTOList[] = new ErrorDTO('Oops, your Zip-Code doesn\'t look right!');
        }
    }

    private function validateAddress($address, &$errorDTOList): void
    {
        $address = $this->trim($address);
        if (strlen($address) >= 20 || strlen($address) <= 2 ||
            !preg_match('/^[a-zA-Z\s-]+$/', $address)) {
            $errorDTOList[] = new ErrorDTO('Oops, your Address doesn\'t look right!');
        }
    }

    private function trim(string $value): string
    {
        return trim($value);
    }
}