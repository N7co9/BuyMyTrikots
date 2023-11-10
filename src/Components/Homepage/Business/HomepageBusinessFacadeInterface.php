<?php

namespace App\Components\Homepage\Business;

interface HomepageBusinessFacadeInterface
{
    public function getPlayers($teamID) : array;
    public function search() : void;
}