<?php

class MineGame {

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

    public function createBoard($mineCount, $hash) {
        $arr = [];
        $PRNG = $this->createPRNG($hash);

        for ($i = 0; $i < 25; $i++) {
            array_push($arr, 'diamond');
        }

        for ($i = 0; $i < $mineCount; $i++) {
            $index = floor($PRNG() * (25 - $i));
            while (isset($arr[$index]) && $arr[$index] === 1) {
                $index = ($index + 1) % 25;
            }
            $arr[$index] = 'mine';
        }

        $this->shuffleBoard($arr, $PRNG, 15);

        $board = $arr;

        return $board;
    }

    public function shuffleBoard(&$arr, $PRNG, $amountOfTimes) {
        for ($i = 0; $i < $amountOfTimes; $i++) {
            for ($j = count($arr) - 1; $j > 0; $j--) {
              $k = floor($PRNG() * ($j + 1));
              list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
            }
        }
    }

}

// Enter details
$serverSeedValue = 'c55ed4fe10a25abca44b14616a6ab0';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3737;
$mineCount = 3; // Number of mines

$mineGame = new MineGame();
$hash = hash_hmac('sha256', $mineGame->getCombinedSeed($serverSeedValue, $clientSeedValue, $nonceValue), false);
$grid = $mineGame->createBoard($mineCount, $hash);

echo 'Result (Array fills in the minefield starting from left and going down (in snake), meaning first 5 array results would be whole left side of mines grid: ';
print_r($grid);

?>
