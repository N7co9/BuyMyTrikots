<?php

namespace App\Global\Business\Mapper;

use App\Global\Business\DTO\OrderDTO;

class BillingMapper
{
    public function mapBilling($array) : OrderDTO
    {
        $billing = new OrderDTO();

        $billing->email = $array['email'];
        $billing->firstName = $array['firstName'];
        $billing->address = $array['address'];
        $billing->lastName = $array['lastName'];
        $billing->totalDue = $array['totalDue'];
        $billing->paymentMethod = $array['payment'];
        $billing->delivery = $array['delivery'];
        $billing->city = $array['city'];
        $billing->zip = $array['zip'];

        return $billing;
    }
}