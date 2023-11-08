<?php

namespace App\Global\Business\Mapper;


use App\Global\Business\DTO\ClientDTO;

class ClientMapper
{
    public function __construct()
    {
    }

    public function mapFromArray2Dto(array $data): ?ClientDTO
    {
        foreach ($data as $entry) {
            $userDTO = new ClientDTO();
            $userDTO->id = $entry['id'];
            $userDTO->username = $entry['username'];
            $userDTO->email = $entry['email'];
            $userDTO->password = $entry['password'];

        }
        return $userDTO ?? null;
    }
}