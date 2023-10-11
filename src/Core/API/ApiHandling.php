<?php declare(strict_types=1);

namespace App\Core\API;


class ApiHandling {
    private function makeApiRequest(string $url): array
    {
        $reqPrefs['http']['method'] = 'GET';
        $reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents('http://api.football-data.org/v4/' . $url, false, $stream_context);
        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }

    public function requestPlayers($teamID) : array
    {
        return $this->makeApiRequest('teams/' . $teamID);
    }

    public function requestItemInfo($itemID) : array
    {
        return $this->makeApiRequest('persons/' . $itemID['item_id']);

    }
}