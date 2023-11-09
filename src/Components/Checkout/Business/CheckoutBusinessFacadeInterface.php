<?php

namespace App\Components\Checkout\Business;

use App\Global\Business\DTO\OrderDTO;

interface CheckoutBusinessFacadeInterface
{
    public function validate(OrderDTO $billingInformation);
    public function redirectIfValid(array $array);
}