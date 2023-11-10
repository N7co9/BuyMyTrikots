<?php

namespace App\Components\UserRegistration\Business;

use App\Components\UserRegistration\Business\Validation\UserValidator;
use App\Components\UserRegistration\Persistence\UserEntityManager;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\ClientDTO;

class UserRegistrationBusinessFacade
{
    public function __construct(
        public UserValidator $validator,
        public UserRepository $userRepository,
        public UserEntityManager $userEntityManager
    )
    {
    }
    public function validate(ClientDTO $clientDTO): array
    {
        return $this->validator->validate($clientDTO);
    }
    public function saveCredentials(ClientDTO $newUser) : string
    {
        return $this->userEntityManager->saveCredentials($newUser);
    }
}