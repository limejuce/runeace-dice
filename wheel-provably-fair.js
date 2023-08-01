// Define colors and segments for the wheel
let segments = {0: 'green', 2: 'black', 4: 'black', 6: 'black', 8: 'black', 10: 'black', 12: 'black', 14: 'black',
            1: 'red', 3: 'red', 5: 'red', 7: 'red', 9: 'red', 11: 'red', 13: 'red'};

// Fill in server seed, client seed, and bet nonce
let serverSeed = 'd011b95378687354504363b5ce9a08';
let clientSeed = '189c8c79aee965fa83b392269a33cd';
let betNonce = 3071;
let color = 'red'; // user picked color

let seed = getCombinedSeed(serverSeed, clientSeed, betNonce);
let PRNG = createPRNG(seed);
let spinResult = getSpinResult(color, segments, PRNG);
let resultColor = segments[spinResult];

console.log(`Resulting Color: ${resultColor}`);

function getSpinResult(userPick, segments, PRNG) {
    // Segment keys for 'green', 'red', 'black'
    let greenSegmentKeys = Object.keys(segments).filter(key => segments[key] === 'green');
    let redSegmentKeys = Object.keys(segments).filter(key => segments[key] === 'red');
    let blackSegmentKeys = Object.keys(segments).filter(key => segments[key] === 'black');

    // Probabilities for 'green', 'red', and 'black'
    let greenProb = 1 / 15;
    let redProb = (userPick === 'red') ? (7 / 15) * 0.92 : 7 / 15;
    let blackProb = (userPick === 'black') ? (7 / 15) * 0.92 : 7 / 15;

    // Choose segment based on generated random number and segment probabilities
    let rand = PRNG();
    let segmentKey;
    if (rand < greenProb) {
        segmentKey = greenSegmentKeys[Math.floor(rand * greenSegmentKeys.length)];
    } else if (rand < greenProb + redProb) {
        let randAdjusted = (rand - greenProb) / redProb;
        segmentKey = redSegmentKeys[Math.floor(randAdjusted * redSegmentKeys.length)];
    } else {
        let randAdjusted = (rand - greenProb - redProb) / blackProb;
        segmentKey = blackSegmentKeys[Math.floor(randAdjusted * blackSegmentKeys.length)];
    }

    return segmentKey;
}

function createPRNG(seed) {
    let index = 0;
    return function() {
        let number = parseInt(seed.substr(index, 2), 16) / 255;
        index = (index + 2) % 64;
        return number;
    };
}

function getCombinedSeed(serverSeed, clientSeed, nonce) {
    return `${serverSeed}-${clientSeed}-${nonce}`;
}
