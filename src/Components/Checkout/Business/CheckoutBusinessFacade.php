<?php

namespace App\Components\Checkout\Business;

use App\Components\Checkout\Business\Validation\BillingValidator;

class CheckoutBusinessFacade implements  CheckoutBusinessFacadeInterface
{
    public function __construct(
        public BillingValidator $billingValidator
    )
    {

    }
    public function validate($billingInformation) : array
    {
        return $this->billingValidator->validate($billingInformation);
    }
    public function redirectIfValid($array) : void
    {
        $this->billingValidator->redirectIfValid($array);
    }
}