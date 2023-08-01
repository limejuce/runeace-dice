<?php
class KenoGame {
    private function combineSeeds($serverSeed, $clientSeed, $nonce) {
        return $serverSeed.'-'.$clientSeed.'-'.$nonce;
    }

    private function createPseudoRandomNumberGenerator($hash) {
        $seed = hexdec(substr($hash, 0, 10));
        $state = $seed % 2147483647;

        if ($state <= 0) {
            $state += 2147483646;
        }

        return function() use (&$state) {
            $state = ($state * 16807) % 2147483647;
            return ($state - 1) / 2147483646;
        };
    }

    private function shuffleArray(&$grid, $pseudoRandomNumberGenerator) {
        for ($i = count($grid) - 1; $i > 0; $i--) {
            $j = floor($pseudoRandomNumberGenerator() * ($i + 1));
            list($grid[$i], $grid[$j]) = array($grid[$j], $grid[$i]);
        }
    }

    public function generatePlayerPicks($serverSeed, $clientSeed, $nonce) {
        $combinedSeed = $this->combineSeeds($serverSeed, $clientSeed, $nonce);
        $hash = hash_hmac('sha256', $combinedSeed, false);
        $pseudoRandomNumberGenerator = $this->createPseudoRandomNumberGenerator($hash);

        $grid = range(1, 40);
        $this->shuffleArray($grid, $pseudoRandomNumberGenerator);

        $playerPicks = array_slice($grid, 0, 10);

        return $playerPicks;
    }
}

// Usage:
$kenoGame = new KenoGame();

// Enter details
$serverSeedValue = 'e56c6e48b36721932e3e017423b834';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3759;
// Click RUN

$picked = $kenoGame->generatePlayerPicks($serverSeedValue, $clientSeedValue, $nonceValue);

echo 'Numbers Hit: ';
print_r($picked);
