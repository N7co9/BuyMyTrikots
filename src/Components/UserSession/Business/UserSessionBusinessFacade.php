<?php

namespace App\Components\UserSession\Business;

use App\Components\UserSession\Persistence\UserCredentialsRepository;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\ClientDTO;

class UserSessionBusinessFacade
{
    public function __construct(
        public UserRepository $userRepository,
        public UserCredentialsRepository $credentialsRepository
    )
    {
    }

    public function findByMail(string $mail): ?ClientDTO
    {
        return $this->userRepository->findByMail($mail);
    }

    public function getUserID(string $mail): ?int
    {
        return  $this->userRepository->getUserID($mail);
    }
    public function checkLoginCredentials(ClientDTO $clientDTO) : bool
    {
        return $this->credentialsRepository->checkLoginCredentials($clientDTO);
    }
}