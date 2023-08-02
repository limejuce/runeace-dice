<?php
class WheelGame {

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

    public function getSpinResult($serverSeed, $clientSeed, $nonce, $userPick, $segments) {
        $seed = $this->getCombinedSeed($serverSeed, $clientSeed, $nonce);
        $hash = hash_hmac('sha256', $seed, false);
        $PRNG = $this->createPRNG($hash);
      
        // Segment keys for 'green', 'red', 'black'
        $greenSegmentKeys = array_keys($segments, 'green');
        $redSegmentKeys = array_keys($segments, 'red');
        $blackSegmentKeys = array_keys($segments, 'black');

        // Probabilities for 'green', 'red', and 'black'
        $greenProb = 1 / 15;
        $redProb = ($userPick == 'red') ? (7 / 15) * 0.92 : 7 / 15;
        $blackProb = ($userPick == 'black') ? (7 / 15) * 0.92 : 7 / 15;

        // Choose segment based on generated PRNG value
        $PRNGvalue = $PRNG();
        if ($PRNGvalue < $greenProb) {
            $segmentKey = $this->selectSegment($greenSegmentKeys, $PRNGvalue);
        } elseif ($PRNGvalue < $greenProb + $redProb) {
            $PRNGvalueAdjusted = ($PRNGvalue - $greenProb) / $redProb;
            $segmentKey = $this->selectSegment($redSegmentKeys, $PRNGvalueAdjusted);
        } else {
            $PRNGvalueAdjusted = ($PRNGvalue - $greenProb - $redProb) / $blackProb;
            $segmentKey = $this->selectSegment($blackSegmentKeys, $PRNGvalueAdjusted);
        }

        return $segmentKey;
    }

    private function selectSegment($segmentKeys, $PRNGvalue) {
        $index = (int) floor($PRNGvalue * count($segmentKeys));

        return $segmentKeys[$index];
    }
}

// Enter details
$serverSeedValue = '8d2f09fb787a7a6ca8d7ac149dff87';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3731;
$color = 'red'; // your selected color

$segments = array(0 => 'green',
            2 => 'black', 4 => 'black', 6 => 'black', 8 => 'black', 10 => 'black', 12 => 'black', 14 => 'black',
            1 => 'red', 3 => 'red', 5 => 'red', 7 => 'red', 9 => 'red', 11 => 'red', 13 => 'red');

$wheelGame = new WheelGame();
$rng = $wheelGame->getSpinResult($serverSeedValue, $clientSeedValue, $nonceValue, $color, $segments);
$color_from_array = $rng - 1;
$r_color = $segments[$color_from_array];

echo $r_color;
