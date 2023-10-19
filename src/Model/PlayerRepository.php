<?php

namespace App\Model;

use App\Core\API\ApiCache;
use App\Core\API\ApiHandling;
use App\Core\DTO\PlayerDTO;
use App\Core\Mapper\ApiMapper;

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