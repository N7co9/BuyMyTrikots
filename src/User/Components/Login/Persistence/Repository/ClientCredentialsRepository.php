<?php

namespace App\User\Components\Login\Persistence\Repository;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ClientMapper;
use App\Global\Persistence\Repository\ClientRepository;

class ClientCredentialsRepository
{
    public ClientRepository $clientRepository;
    public ClientMapper $clientMapper;
    public function __construct()
    {
        $this->clientRepository = new ClientRepository();
        $this->clientMapper = new ClientMapper();
    }
    public function checkLoginCredentials(ClientDTO $clientDTO): bool
    {
        $userDTO = $this->clientRepository->findByMail($clientDTO->email);
        return $userDTO instanceof ClientDTO && password_verify($clientDTO->password, $userDTO->password);
    }
}