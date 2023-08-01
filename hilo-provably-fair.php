<?php
class CardGame {

    private function getCombinedSeed($serverSeed, $clientSeed, $nonce) {
        return $serverSeed.'-'.$clientSeed.'-'.$nonce;
    }

    private function getDeck() {
        return array(
            1 => array('type' => 'spades', 'value' => 'A', 'rank' => 0, 'slot' => 1, 'blackjackValue' => 11),
            2 => array('type' => 'spades', 'value' => '2', 'rank' => 1, 'slot' => 2, 'blackjackValue' => 2),
            3 => array('type' => 'spades', 'value' => '3', 'rank' => 2, 'slot' => 3, 'blackjackValue' => 3),
            4 => array('type' => 'spades', 'value' => '4', 'rank' => 3, 'slot' => 4, 'blackjackValue' => 4),
            5 => array('type' => 'spades', 'value' => '5', 'rank' => 4, 'slot' => 5, 'blackjackValue' => 5),
            6 => array('type' => 'spades', 'value' => '6', 'rank' => 5, 'slot' => 6, 'blackjackValue' => 6),
            7 => array('type' => 'spades', 'value' => '7', 'rank' => 6, 'slot' => 7, 'blackjackValue' => 7),
            8 => array('type' => 'spades', 'value' => '8', 'rank' => 7, 'slot' => 8, 'blackjackValue' => 8),
            9 => array('type' => 'spades', 'value' => '9', 'rank' => 8, 'slot' => 9, 'blackjackValue' => 9),
            10 => array('type' => 'spades', 'value' => '10', 'rank' => 9, 'slot' => 10, 'blackjackValue' => 10),
            11 => array('type' => 'spades', 'value' => 'J', 'rank' => 10, 'slot' => 11, 'blackjackValue' => 10),
            12 => array('type' => 'spades', 'value' => 'Q', 'rank' => 11, 'slot' => 12, 'blackjackValue' => 10),
            13 => array('type' => 'spades', 'value' => 'K', 'rank' => 12, 'slot' => 13, 'blackjackValue' => 10),
            14 => array('type' => 'hearts', 'value' => 'A', 'rank' => 0, 'slot' => 1, 'blackjackValue' => 11),
            15 => array('type' => 'hearts', 'value' => '2', 'rank' => 1, 'slot' => 2, 'blackjackValue' => 2),
            16 => array('type' => 'hearts', 'value' => '3', 'rank' => 2, 'slot' => 3, 'blackjackValue' => 3),
            17 => array('type' => 'hearts', 'value' => '4', 'rank' => 3, 'slot' => 4, 'blackjackValue' => 4),
            18 => array('type' => 'hearts', 'value' => '5', 'rank' => 4, 'slot' => 5, 'blackjackValue' => 5),
            19 => array('type' => 'hearts', 'value' => '6', 'rank' => 5, 'slot' => 6, 'blackjackValue' => 6),
            20 => array('type' => 'hearts', 'value' => '7', 'rank' => 6, 'slot' => 7, 'blackjackValue' => 7),
            21 => array('type' => 'hearts', 'value' => '8', 'rank' => 7, 'slot' => 8, 'blackjackValue' => 8),
            22 => array('type' => 'hearts', 'value' => '9', 'rank' => 8, 'slot' => 9, 'blackjackValue' => 9),
            23 => array('type' => 'hearts', 'value' => '10', 'rank' => 9, 'slot' => 10, 'blackjackValue' => 10),
            24 => array('type' => 'hearts', 'value' => 'J', 'rank' => 10, 'slot' => 11, 'blackjackValue' => 10),
            25 => array('type' => 'hearts', 'value' => 'Q', 'rank' => 11, 'slot' => 12, 'blackjackValue' => 10),
            26 => array('type' => 'hearts', 'value' => 'K', 'rank' => 12, 'slot' => 13, 'blackjackValue' => 10),
            27 => array('type' => 'clubs', 'value' => 'A', 'rank' => 0, 'slot' => 1, 'blackjackValue' => 11),
            28 => array('type' => 'clubs', 'value' => '2', 'rank' => 1, 'slot' => 2, 'blackjackValue' => 2),
            29 => array('type' => 'clubs', 'value' => '3', 'rank' => 2, 'slot' => 3, 'blackjackValue' => 3),
            30 => array('type' => 'clubs', 'value' => '4', 'rank' => 3, 'slot' => 4, 'blackjackValue' => 4),
            31 => array('type' => 'clubs', 'value' => '5', 'rank' => 4, 'slot' => 5, 'blackjackValue' => 5),
            32 => array('type' => 'clubs', 'value' => '6', 'rank' => 5, 'slot' => 6, 'blackjackValue' => 6),
            33 => array('type' => 'clubs', 'value' => '7', 'rank' => 6, 'slot' => 7, 'blackjackValue' => 7),
            34 => array('type' => 'clubs', 'value' => '8', 'rank' => 7, 'slot' => 8, 'blackjackValue' => 8),
            35 => array('type' => 'clubs', 'value' => '9', 'rank' => 8, 'slot' => 9, 'blackjackValue' => 9),
            36 => array('type' => 'clubs', 'value' => '10', 'rank' => 9, 'slot' => 10, 'blackjackValue' => 10),
            37 => array('type' => 'clubs', 'value' => 'J', 'rank' => 10, 'slot' => 11, 'blackjackValue' => 10),
            38 => array('type' => 'clubs', 'value' => 'Q', 'rank' => 11, 'slot' => 12, 'blackjackValue' => 10),
            39 => array('type' => 'clubs', 'value' => 'K', 'rank' => 12, 'slot' => 13, 'blackjackValue' => 10),
            40 => array('type' => 'diamonds', 'value' => 'A', 'rank' => 0, 'slot' => 1, 'blackjackValue' => 11),
            41 => array('type' => 'diamonds', 'value' => '2', 'rank' => 1, 'slot' => 2, 'blackjackValue' => 2),
            42 => array('type' => 'diamonds', 'value' => '3', 'rank' => 2, 'slot' => 3, 'blackjackValue' => 3),
            43 => array('type' => 'diamonds', 'value' => '4', 'rank' => 3, 'slot' => 4, 'blackjackValue' => 4),
            44 => array('type' => 'diamonds', 'value' => '5', 'rank' => 4, 'slot' => 5, 'blackjackValue' => 5),
            45 => array('type' => 'diamonds', 'value' => '6', 'rank' => 5, 'slot' => 6, 'blackjackValue' => 6),
            46 => array('type' => 'diamonds', 'value' => '7', 'rank' => 6, 'slot' => 7, 'blackjackValue' => 7),
            47 => array('type' => 'diamonds', 'value' => '8', 'rank' => 7, 'slot' => 8, 'blackjackValue' => 8),
            48 => array('type' => 'diamonds', 'value' => '9', 'rank' => 8, 'slot' => 9, 'blackjackValue' => 9),
            49 => array('type' => 'diamonds', 'value' => '10', 'rank' => 9, 'slot' => 10, 'blackjackValue' => 10),
            50 => array('type' => 'diamonds', 'value' => 'J', 'rank' => 10, 'slot' => 11, 'blackjackValue' => 10),
            51 => array('type' => 'diamonds', 'value' => 'Q', 'rank' => 11, 'slot' => 12, 'blackjackValue' => 10),
            52 => array('type' => 'diamonds', 'value' => 'K', 'rank' => 12, 'slot' => 13, 'blackjackValue' => 10),
        );
    }
    
    private function createPRNG($seed) {
        $index = 0;
        return function() use (&$seed, &$index) {
            $number = hexdec(substr($seed, $index, 2)) / 255;
            $index = ($index + 2) % 64;
            return $number;
        };
    }
    
    private function selectCard($potentialCards, $PRNG) {
        $cardKeys = array_keys($potentialCards);
        $PRNGvalue = $PRNG();
        $index = (int) floor($PRNGvalue * count($cardKeys));

        return $cardKeys[$index];
    }

    public function getHiloResult($serverSeed, $clientSeed, $nonce, $userPick, $currentCard) {
        $deck = $this->getDeck();
        $seed = $this->getCombinedSeed($serverSeed, $clientSeed, $nonce);
        $hash = hash_hmac('sha256', $seed, false);
        $PRNG = $this->createPRNG($hash);
        $currentCardRank = $deck[$currentCard]['rank'];

        // Split the deck into higher and lower ranked cards
        $higherCards = array_filter($deck, function($card) use ($currentCardRank) { 
            return $card['rank'] > $currentCardRank; 
        });
        $lowerCards = array_filter($deck, function($card) use ($currentCardRank) { 
            return $card['rank'] < $currentCardRank; 
        });

        $totalHigherCards = count($higherCards);
        $totalLowerCards = count($lowerCards);

        // Decide which cards we are drawing from and calculate result including edge
        if ($userPick == 'higher') {
            $percentageHigherCards = $totalHigherCards / ($totalHigherCards + $totalLowerCards);
            $adjustedPercentage = $percentageHigherCards - ($percentageHigherCards * 0.08);
            $randomFloat = $PRNG();

            if ($randomFloat < $adjustedPercentage) {
                $potentialCards = $higherCards;
            } else {
                $potentialCards = $lowerCards;
            }
        } else {  // $userPick == 'lower'
            $percentageLowerCards = $totalLowerCards / ($totalHigherCards + $totalLowerCards);
            $adjustedPercentage = $percentageLowerCards - ($percentageLowerCards * 0.08);
            $randomFloat = $PRNG();

            if ($randomFloat < $adjustedPercentage) {
                $potentialCards = $lowerCards;
            } else {
                $potentialCards = $higherCards;
            }
        }

        $selectedCardKey = $this->selectCard($potentialCards, $PRNG);

        return $selectedCardKey;
    }

}

// Enter details from RuneAce
$serverSeedValue = 'fa2dcea6223408d21e6bae3a320c1b';
$clientSeedValue = '189c8c79aee965fa83b392269a33cd';
$nonceValue = 3728;
$user_pick = 'lower'; // user selected 'higher' or 'lower'
$current_card = 45;
// Click RUN

$hiloGame = new CardGame();
$result = $hiloGame->getHiloResult($serverSeedValue, $clientSeedValue, $nonceValue, $user_pick, $current_card);
echo $result;
