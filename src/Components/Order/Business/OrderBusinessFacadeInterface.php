<?php

namespace App\Components\Order\Business;

use App\Global\Business\DTO\OrderDTO;

interface OrderBusinessFacadeInterface
{
    public function getOrderInformation() : OrderDTO;
}