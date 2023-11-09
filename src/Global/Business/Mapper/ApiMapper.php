<?php

namespace App\Global\Business\Mapper;

use App\Global\Business\DTO\BasketDTO;
use App\Global\Business\DTO\PlayerDTO;

class ApiMapper
{
    /**
     * @param $array
     * @return PlayerDTO[]
     */
    public function Map($array) : array
    {
        $list = [];
        foreach ($array['squad'] ?? [] as $item)
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

    public function MapBasket($array, $quantity) : BasketDTO
    {
            $DTO = new BasketDTO();
            $DTO->name = $array['name'] . ' Trikot';
            $DTO->icon = $array['currentTeam']['crest'];
            $DTO->id = $array['id'];
            $DTO->quantity = $quantity[0]['quantity'];

        return $DTO;
    }
}