<?php

namespace App\Components\UserRegistration\Business;

use App\Global\Business\DTO\ClientDTO;

interface UserRegistrationBusinessFacadeInterface
{
    public function validate(ClientDTO $clientDTO);
}