<?php

namespace App\Components\Homepage\Business;

use App\Components\Homepage\Persistence\Repository\PlayerRepository;

class HomepageBusinessFacade implements HomepageBusinessFacadeInterface
{
    public function __construct(
        public PlayerRepository $playerRepository,
        public SearchEngine     $searchEngine
    )
    {
    }

    public function getPlayers($teamID): array
    {
        return $this->playerRepository->getPlayers($teamID);
    }

    public function search(): void
    {
        $this->searchEngine->search();
    }

}