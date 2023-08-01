<?php
class TowerGame {
    private function combineSeeds($serverSeed, $clientSeed, $nonce) {
        return $serverSeed.'-'.$clientSeed.'-'.$nonce;
    }

    private function createPseudoRandomNumberGenerator($seed) {
        $index = 0;
        return function() use (&$seed, &$index) {
            $number = hexdec(substr($seed, $index, 2)) / 255;
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

    public function generateTowerGrid($towerLevels, $minesPerLevel, $stepsPerLevel, $serverSeed, $clientSeed, $nonce) {
        $combinedSeed = $this->combineSeeds($serverSeed, $clientSeed, $nonce);
        $pseudoRandomNumberGenerator = $this->createPseudoRandomNumberGenerator($combinedSeed);

        $tower = [];
        for ($i = 0; $i < $towerLevels; $i++) {
            $level = array_fill(0, $stepsPerLevel, 0); // Initially all cells are safe

            // Pick mine positions
            $positions = range(0, $stepsPerLevel - 1);
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
$towerLevels = 10;
$stepsPerLevel = 5;

$combinedArray = $towerGame->generateTowerGrid($towerLevels, $mines, $stepsPerLevel, $server_seed, $client_seed, $bet_nonce);
$grid = $combinedArray['tower'];
