<?php

class DiceGame {

    private $edge = 5;

    public function getCombinedSeed($serverSeed, $clientSeed, $nonce) {
        return $serverSeed.'-'.$clientSeed.'-'.$nonce;
    }

    public function createPRNGDice($seed) {
        $m = pow(2, 32);
        $a = 1103515245;
        $c = 12345;

        // Convert hexadecimal seed to decimal
        $seed = hexdec(substr($seed, 0, 8));  // only use the first 8 characters to avoid overflow

        return function() use (&$seed, $m, $a, $c) {
            $seed = ($a * $seed + $c) % $m;
            return $seed / $m;
        };
    }

    public function getDiceResult($serverSeed, $clientSeed, $nonce, $chance, $type) {
        $seed = $this->getCombinedSeed($serverSeed, $clientSeed, $nonce);
        $PRNG = $this->createPRNGDice($seed);
        $roll = round($PRNG() * 100); // scale to 0-100 and round to nearest integer

        // Apply house edge
        if ($type == 'higher') {
            $rollWithEdge = max(0, min(100, $roll - $this->edge));  // roll is reduced by the edge when higher numbers win
        } else {
            $rollWithEdge = max(0, min(100, $roll + $this->edge));  // roll is increased by the edge when lower numbers win
        }
        return $rollWithEdge;
    }
}

// Enter details
$serverSeedValue = '594c55c45a4504247bc29940f824c1';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3732;
$chance = 40;
$type = 'lower'; 

$diceGame = new DiceGame();
$win = $diceGame->getDiceResult($serverSeedValue, $clientSeedValue, $nonceValue, $chance, $type);

echo $win;

?>
