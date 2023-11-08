<?php

namespace App\Components\Homepage\Persistence\Repository;

use App\Global\Business\DTO\PlayerDTO;
use App\Global\Business\Mapper\ApiMapper;
use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;

class PlayerRepository
{
    public function __construct(private readonly ApiHandling $apiHandling, private readonly ApiMapper $mapper, private ApiCache $apiCache)
    {
        $this->apiCache = new ApiCache($this->apiHandling);
    }

    public function getPlayers($teamID) : array
    {
        $rawPlayerArray = $this->apiCache->getData('players', $teamID);

        return $this->mapper->Map($rawPlayerArray);
    }
}