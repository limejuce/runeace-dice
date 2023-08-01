<?php

class CoinFlipGame {

    public function getCombinedSeed($serverSeed, $clientSeed, $nonce) {
        return $serverSeed.'-'.$clientSeed.'-'.$nonce;
    }

    public function createPRNG($seed) {
        $index = 0;
        return function() use (&$seed, &$index) {
            $number = hexdec(substr($seed, $index, 2)) / 255;
            $index = ($index + 2) % 64;
            return $number;
        };
    }

    public function getFlipResult($serverSeed, $clientSeed, $nonce, $userPick) {
        $seed = $this->getCombinedSeed($serverSeed, $clientSeed, $nonce);
        $hash = hash_hmac('sha256', $seed, false);
        $PRNG = $this->createPRNG($hash);

        // Probabilities for 'red' and 'black'
        $redProb = ($userPick == 'red') ? 0.5 * 0.92 : 0.5;
        $blackProb = ($userPick == 'black') ? 0.5 * 0.92 : 0.5;

        // Choose side based on generated random number and side probabilities
        $rand = $PRNG();
        if ($rand < $redProb) {
            return 'red';
        } else {
            return 'black';
        }
    }
}

// Enter details
$serverSeedValue = '7cbd7a397d2f272bde00fca4874d77';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3735;
$side = 'black'; // red or black - user pick

$coinFlipGame = new CoinFlipGame();
$result = $coinFlipGame->getFlipResult($serverSeedValue, $clientSeedValue, $nonceValue, $side);

echo 'Result: ' . $result;

?>
