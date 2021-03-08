<?php

namespace App\Service;

use App\Entity\Kraken;
use App\Entity\KrakenPower;
use App\Repository\KrakenPowerRepository;
use App\Repository\KrakenRepository;
use App\Repository\PowerRepository;
use App\Repository\TentacleRepository;

class KrakenService
{
    private $tentacleRepository;
    private $krakenRepository;
    private $powerRepository;
    private $krakenPowerRepository;
    private $diceService;

    public function __construct(DiceService $diceService, TentacleRepository $tentacleRepository, KrakenRepository $krakenRepository, PowerRepository $powerRepository, KrakenPowerRepository $krakenPowerRepository)
    {
        $this->diceService = $diceService;
        $this->tentacleRepository = $tentacleRepository;
        $this->krakenRepository = $krakenRepository;
        $this->powerRepository = $powerRepository;
        $this->krakenPowerRepository = $krakenPowerRepository;
    }

    /**
     * Check the maximum of tentacle allowed for 1 kraken
     * 
     * @param Kraken $kraken
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
     * @param Kraken $kraken
     * 
     * @param int $power_id
     * 
     * @return KrakenPower
     */
    public function createKrakenPower($kraken, $power_id)
    {
        $kraken_power = new KrakenPower();
        $kraken_power->setKraken($kraken);
        $kraken_power->setPower($this->powerRepository->find($power_id));
        $kraken_power->setMaxUsage($this->diceService->rollDices(2, 4));
        return $kraken_power;
    }

    /**
     * Check can add power
     * 
     * @param Kraken $kraken
     * 
     * @return bool
     */
    public function canAddKrakenPower($kraken)
    {
        $krakenPowerNb = count($this->krakenPowerRepository->findBy(["kraken" => $kraken]));
        $tentacleNb = count($this->tentacleRepository->findBy(["kraken" => $kraken]));

        if ($krakenPowerNb == 0) {
            return true;
        } else if ($krakenPowerNb == 1) {
            if ($tentacleNb >= 4) {
                return true;
            }
        } else if ($krakenPowerNb == 2) {
            if ($tentacleNb >= 8) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get kraken details
     * 
     * @param int $id Kraken id
     * 
     * @return array Kraken details
     */
    public function getKrakenDetails($id)
    {
        $kraken = $this->krakenRepository->find($id);
        $tentacles = $kraken->getTentacles();
        $powers = $this->krakenPowerRepository->findBy(["kraken" => $kraken]);
        $result = $kraken->toArray();
        foreach ($tentacles as $tentacle) {
            $result["tentacles"][] = $tentacle->toArray();
        }
        foreach ($powers as $power) {
            $result["powers"][] = $power->toArray();
        }

        return $result;
    }
}
