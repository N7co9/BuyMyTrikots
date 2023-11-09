<?php

namespace App\Components\UserSession\Persistence;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Mapper\ClientMapper;
use App\Global\Persistence\SQL\SqlConnector;


class UserRepository
{
    public function __construct(public ClientMapper $clientMapper, public SqlConnector $sqlConnector)
    {
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