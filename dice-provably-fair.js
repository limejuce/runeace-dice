// This must be filled in with details you can get from RuneAce.com
let serverSeed = 'd011b95378687354504363b5ce9a08';
let clientSeed = '189c8c79aee965fa83b392269a33cd';
let betNonce = 3071;
let chance = 43; // selected number by user
let type = 'lower'; // if user selects higher numbers be winning = higher, if lower numbers = lower 
// Then press Run button here 

let seed = getCombinedSeed(serverSeed, clientSeed, betNonce);
let PRNG = createPRNGDice(seed);
let roll = Math.round(PRNG() * 100);
let rollWithEdge;

let edge = 5;

if (type === 'higher') {
    rollWithEdge = Math.max(0, Math.min(100, roll - edge));
} else {
    rollWithEdge = Math.max(0, Math.min(100, roll + edge));
}

console.log(`Roll: ${rollWithEdge}`);

function createPRNGDice(seed) {
    let m = Math.pow(2, 32);
    let a = 1103515245;
    let c = 12345;
    
    // Convert hexadecimal seed to decimal
    seed = parseInt(seed.substr(0, 8), 16);  // only use the first 8 characters to avoid overflow

    return function() {
        seed = (a * seed + c) % m;
        return seed / m;
    };
}

function getCombinedSeed(serverSeed, clientSeed, nonce) {
    return serverSeed+'-'+clientSeed+'-'+nonce;
}
