<?php

namespace App\Global\Persistence\Repository;

use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;
use App\Global\Business\DTO\PlayerDTO;
use App\Global\Business\Mapper\ApiMapper;

class PlayerRepository
{
    private ApiHandling $apiHandling;
    private ApiMapper $mapper;
    private ApiCache $apiCache;
    public function __construct()
    {
        $this->apiHandling = new ApiHandling();
        $this->mapper = new ApiMapper();
        $this->apiCache = new ApiCache($this->apiHandling);
    }

    /**
     * @return PlayerDTO[]
     */
    public function getPlayers($teamID) : array
    {
        $rawPlayerArray = $this->apiCache->getData('players', $teamID);

        return $this->mapper->Map($rawPlayerArray);
    }
}