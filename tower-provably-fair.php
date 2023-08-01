<?php

class TowerGame {
    private function combineSeeds($serverSeed, $clientSeed, $nonce) {
        return $serverSeed.'-'.$clientSeed.'-'.$nonce;
    }

    private function createPseudoRandomNumberGenerator($seed) {
        $index = 0;
        return function() use (&$seed, &$index) {
            // Ensure $index is within bounds of $seed.
            if ($index >= strlen($seed)) {
                $index = 0;
            }
            $hexStr = substr($seed, $index, 2);
            // Ensure $hexStr is a valid hexadecimal number.
            if (ctype_xdigit($hexStr)) {
                $number = hexdec($hexStr) / 255;
            } else {
                $number = 0;
            }
            $index = ($index + 2) % 64;
            return $number;
        };
    }

    private function shuffleArray(&$array, $pseudoRandomNumberGenerator) {
        $n = count($array);
        while ($n > 1) {
            $k = floor($pseudoRandomNumberGenerator() * $n--);
            list($array[$n], $array[$k]) = array($array[$k], $array[$n]);
        }
    }

    public function generateTowerGrid($minesPerLevel, $serverSeed, $clientSeed, $nonce) {
        $combinedSeed = $this->combineSeeds($serverSeed, $clientSeed, $nonce);
        $pseudoRandomNumberGenerator = $this->createPseudoRandomNumberGenerator($combinedSeed);

        $tower = [];
        for ($i = 0; $i < 10; $i++) {
            $level = array_fill(0, 5, 0); // Initially all cells are safe

            // Pick mine positions
            $positions = range(0, 5 - 1);
            $this->shuffleArray($positions, $pseudoRandomNumberGenerator);
            $minePositions = array_slice($positions, 0, $minesPerLevel);

            // Place mines at the picked positions
            foreach ($minePositions as $position) {
                $level[$position] = 1; // Place a mine
            }
            
            $tower[] = $level;
        }

        // Creating a single hash for the entire tower
        $hash = hash('sha256', json_encode($tower) . $serverSeed);

        return ['tower' => $tower, 'hash' => $hash];
    }
}

// Usage:
$towerGame = new TowerGame();

// Enter details
$serverSeedValue = 'e56c6e48b36721932e3e017423b834';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3759;
$mines = 1;
// Click RUN

$combinedArray = $towerGame->generateTowerGrid($mines, $serverSeedValue, $clientSeedValue, $nonceValue);
$grid = $combinedArray['tower'];

echo 'Grid: ';
print_r($grid);
