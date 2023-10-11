<?php

namespace App\Core\Mapper;

use App\Core\DTO\PlayerDTO;

class ApiMapper
{
    public function Map($array) : array
    {
        $list = [];
        foreach ($array['squad'] as $item)
        {
            $DTO = new PlayerDTO();
            $DTO->id = $item['id'];
            $DTO->name = $item['name'];
            $DTO->nationality = $item['nationality'];
            $DTO->dateOfBirth = $item['dateOfBirth'];
            $DTO->clubEmblem = $array['crest'];
            $DTO->clubAddress = $array['address'];
            $DTO->clubFounded = $array['founded'];
            $DTO->clubName = $array['name'];
            $DTO->clubWebsite = $array['website'];

            $list [] = $DTO;
        }
        return $list;
    }
}