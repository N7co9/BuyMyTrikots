<?php

namespace App\Model;

use App\Core\DTO\ClientDTO;
use App\Core\Mapper\ClientMapper;


class ClientRepository
{
    public ClientMapper $clientMapper;
    public \App\Core\SQL\SqlConnector $sqlConnector;
    public function __construct()
    {
        $this->clientMapper = new ClientMapper();
        $this->sqlConnector = new \App\Core\SQL\SqlConnector();
    }
    public function findByMail(string $mail): ?ClientDTO
    {
        $array = $this->sqlConnector->executeSelectQuery("SELECT * FROM users where email = :mail", [':mail' => $mail]);
        return $this->clientMapper->mapFromArray2Dto($array);
    }

    public function checkLoginCredentials(ClientDTO $clientDTO): bool
    {
        $userDTO = $this->findByMail($clientDTO->email);
        if ($userDTO instanceof ClientDTO && password_verify($userDTO->password, $clientDTO->password)) {
            return true;
        }
        return false;
    }

    public function getUserID(string $mail) : ?int
    {
        $rawIdArray =  $this->sqlConnector->executeSelectQuery("SELECT users.id FROM users where users.email = :mail", [":mail" => $mail]);

        foreach ($rawIdArray as $entry){
            $formattedId = $entry['id'];
        }

        return $formattedId ?? null;
    }

}