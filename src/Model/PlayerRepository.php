<?php

namespace App\Model;

use App\Core\API\ApiHandling;
use App\Core\Mapper\ApiMapper;

class PlayerRepository
{
    private ApiHandling $apiHandling;
    private ApiMapper $mapper;
    public function __construct()
    {
        $this->apiHandling = new ApiHandling();
        $this->mapper = new ApiMapper();
    }
    public function getPlayers($teamID) : array
    {
        $rawPlayerArray = $this->apiHandling->requestPlayers($teamID);

        return $this->mapper->Map($rawPlayerArray);
    }
}