<?php

namespace App\Service;

use App\Entity\Kraken;
use App\Entity\Tentacle;
use App\Repository\TentacleRepository;

class KrakenService
{
    private $tentacleRepository;

    public function __construct(TentacleRepository $tentacleRepository)
    {
        $this->tentacleRepository = $tentacleRepository;
    }

    /**
     * Check the maximum of tentacle allowed for 1 kraken
     * 
     * @param $tentacle
     * 
     * @return bool tentacle allowed to be added or not
     * 
     */
    public function checkAddTentacle($kraken)
    {
        return count($this->tentacleRepository->findBy(["kraken" => $kraken])) < Kraken::MAX_TENTACLE;
    }
}
