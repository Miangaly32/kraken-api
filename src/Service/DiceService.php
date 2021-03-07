<?php

namespace App\Service;

class DiceService
{
    /**
     * 
     * Rolling n dices with n faces
     * 
     * @param int $dices number of dices to roll
     * 
     * @param int $faces dices' faces
     * 
     * @param int $result 
     * 
     * @param int $nb 
     *      
     */
    public function rollDices($dices, $faces, $result = 0, $nb = 0)
    {
        if ($nb == $dices)
            return $result;

        $result = rand(1, $faces) + $result;

        $this->rollDices($dices, $faces, $result, $nb + 1);
    }
}
