<?php

namespace App\Service;

class TentacleService
{
    public function __construct(DiceService $diceService)
    {
        $this->diceService = $diceService;
    }

    /**
     * Init tentacle
     */
    public function initTentacle($tentacle)
    {
        $tentacle->setPv($this->diceService->rollDices(6, 6));
        $tentacle->setStrength(10 + $this->diceService->rollDices(6, 6));
        $tentacle->setDex(10 + $this->diceService->rollDices(6, 6));
        $tentacle->setCon(10 + $this->diceService->rollDices(6, 6));
    }
}
