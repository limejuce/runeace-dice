// User selected color
let color = 'red';

// Wheel structure
let segments = {
    0: 'green',
    1: 'red', 3: 'red', 5: 'red', 7: 'red', 9: 'red', 11: 'red', 13: 'red',
    2: 'black', 4: 'black', 6: 'black', 8: 'black', 10: 'black', 12: 'black', 14: 'black',
};

// Server seed, client seed, and bet nonce should be provided or generated
let serverSeed = 'b4923d08acf3b799c5444c6c1b9988';
let clientSeed = '189c8c79aee965fa83b392269a33cd';
let betNonce = 3604;
// Click RUN

// Calculate the spin result
let spinResult = getSpinResult(serverSeed, clientSeed, betNonce, color, segments);

// Get the color of the resulting segment
let resultingColor = segments[spinResult];

console.log(`Spin Result: ${spinResult}`);
console.log(`Resulting Color: ${resultingColor}`);

function getSpinResult(serverSeed, clientSeed, nonce, userPick, segments) {
    let seed = getCombinedSeed(serverSeed, clientSeed, nonce);
    let hash = require('crypto').createHmac('sha256', seed).digest('hex');
    let PRNG = createPRNG(hash);

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
