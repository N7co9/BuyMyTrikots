<?php

namespace App\Global\Persistence\Repository;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ClientMapper;


class ClientRepository
{
    public ClientMapper $clientMapper;
    public \App\Global\Persistence\SQL\SqlConnector $sqlConnector;
    public function __construct()
    {
        $this->clientMapper = new ClientMapper();
        $this->sqlConnector = new \App\Global\Persistence\SQL\SqlConnector();
    }
    public function findByMail(string $mail): ?ClientDTO
    {
        $array = $this->sqlConnector->executeSelectQuery("SELECT * FROM users where email = :mail", [':mail' => $mail]);
        return $this->clientMapper->mapFromArray2Dto($array);
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