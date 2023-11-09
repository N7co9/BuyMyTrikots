<?php

namespace App\Components\UserSession\Business;

use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\DTO\ClientDTO;

class UserSessionBusinessFacade
{
    public function __construct(public UserRepository $userRepository)
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
}