<?php

namespace App\Components\User\Persistence\Repository;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ClientMapper;

class UserCredentialsRepository
{
    public function __construct(public UserRepository $userRepository, public ClientMapper $clientMapper)
    {
    }
    public function checkLoginCredentials(ClientDTO $clientDTO): bool
    {
        $userDTO = $this->userRepository->findByMail($clientDTO->email);
        return $userDTO instanceof ClientDTO && password_verify($clientDTO->password, $userDTO->password);
    }
}