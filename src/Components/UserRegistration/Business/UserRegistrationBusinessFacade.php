<?php

namespace App\Components\UserRegistration\Business;

use App\Components\UserRegistration\Business\Validation\UserValidator;
use App\Global\Business\DTO\ClientDTO;

class UserRegistrationBusinessFacade
{
    public function __construct(
        public UserValidator $validator
    )
    {
    }
    public function validate(ClientDTO $clientDTO): array
    {
        return $this->validator->validate($clientDTO);
    }
}