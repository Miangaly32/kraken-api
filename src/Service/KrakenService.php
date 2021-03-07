<?php

namespace App\Service;

use App\Entity\Kraken;
use App\Entity\KrakenPower;
use App\Repository\KrakenRepository;
use App\Repository\PowerRepository;
use App\Repository\TentacleRepository;

class KrakenService
{
    private $tentacleRepository;
    private $krakenRepository;
    private $powerRepository;
    private $diceService;

    public function __construct(DiceService $diceService, TentacleRepository $tentacleRepository, KrakenRepository $krakenRepository, PowerRepository $powerRepository)
    {
        $this->diceService = $diceService;
        $this->tentacleRepository = $tentacleRepository;
        $this->krakenRepository = $krakenRepository;
        $this->powerRepository = $powerRepository;
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

    /**
     * Create Kraken_power
     * 
     * @param $kraken_id
     * 
     * @param $power_id
     * 
     * @return KrakenPower
     */
    public function createKrakenPower($kraken_id, $power_id)
    {
        $kraken_power = new KrakenPower();
        $kraken_power->setKraken($this->krakenRepository->find($kraken_id));
        $kraken_power->setPower($this->powerRepository->find($power_id));
        $kraken_power->setMaxUsage($this->diceService->rollDices(2, 4));
        return $kraken_power;
    }
}
