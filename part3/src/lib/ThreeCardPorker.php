<?php

/*
カードを判定する
役を判定する
勝敗を判定する
*/

use phpDocumentor\Reflection\Types\Boolean;

const CARDS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $index => $card) {
        $cardRanks[$card] = $index;
    }
    return $cardRanks;
})());
const HIGH_CARD  = 'high card';
const PAIR       = 'pair';
const STRAIGHT   = 'straight';
const THREE_CARD = 'three card';
const HAND_RANK = [
    HIGH_CARD  => 0,
    PAIR       => 1,
    STRAIGHT   => 2,
    THREE_CARD => 3
];
//const ROLE = ['high card', 'pair', 'straight'];
const PLAYER1 = 1;
const PLAYER2 = 2;
const DRAW    = 0;
//const J = 11;
//const Q = 12;
//const K = 13;
//const A = 14;
//const KA = [13, 14];
//const A2 = [2, 14];



function show(string $p1_1, string $p1_2, string $p2_1, string $p2_2, string $p3_1, string $p3_2): array
{
    //数値だけを取り出し、ランク付けされた値を取得
    $cardRanks = convertToCardRanks([$p1_1, $p1_2, $p2_1, $p2_2, $p3_1, $p3_2]);
    //プレイヤーごとにカードを分割
    $playerCardRanks = array_chunk($cardRanks, 3);
    //役を格納 カードは3枚
    $hands = array_map(fn ($playerCardRanks) => checkHand($playerCardRanks), $playerCardRanks);
    //勝者を判定
    $winner = decideWinner($hands[0], $hands[1]);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
}

function convertToCardRanks(array $cards): array
{
    return array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);
}

function checkHand(array $cardRanks): array
{
    rsort($cardRanks);
    $sortCardRanks = $cardRanks;
    $name = HIGH_CARD;

    if (isThreeCard($sortCardRanks)) {
        $name = THREE_CARD;
    } elseif (isPair($sortCardRanks)) {
        $name = PAIR;
    } elseif (isStraight($sortCardRanks)) {
        $name = STRAIGHT;
        $sortCardRanks = cardRotate($sortCardRanks);
    }
    return [
        'name' => $name,
        'rank' => HAND_RANK[$name],
        'sortCardRanks' => $sortCardRanks,
    ];
}

function isThreeCard(array $sortCardRanks): bool
{
    return (count(array_keys($sortCardRanks, $sortCardRanks[0])) === 3);
}

function isPair(array $sortCardRanks): bool
{
    for ($i = 0; $i < count($sortCardRanks); $i++) {
        for ($j = $i + 1; $j < count($sortCardRanks); $j++) {
            if ($sortCardRanks[$i] === $sortCardRanks[$j]) {
                return true;
            }
        }
    }
    return false;
}

function isStraight(array $sortCardRanks): bool
{
    for ($i = 0; $i < count($sortCardRanks) - 2; $i++) {
        if (((abs($sortCardRanks[$i + 2] - $sortCardRanks[$i + 1]) === 1) && (abs($sortCardRanks[$i + 1] - $sortCardRanks[$i])) === 1) ||
            ((abs($sortCardRanks[$i] - $sortCardRanks[$i + 2]) === 12) && (abs($sortCardRanks[$i + 1] - $sortCardRanks[$i + 2]) === 1))
        ) {
            return true;
        }
    }
    return false;
}

function cardRotate(array $sortCardRanks): array
{
    for ($i = 0; $i < count($sortCardRanks) - 2; $i++) {
        if (((abs($sortCardRanks[$i] - $sortCardRanks[$i + 2]) === 12) && (abs($sortCardRanks[$i + 1] - $sortCardRanks[$i + 2]) === 1))) {
            $tmp = $sortCardRanks[0];
            array_shift(($sortCardRanks));
            $sortCardRanks[] = $tmp;
        }
    }
    return $sortCardRanks;
}

function decideWinner($hand1, $hand2): int
{
    if ($hand1['rank'] > $hand2['rank']) {
        return PLAYER1;
    } elseif ($hand1['rank'] < $hand2['rank']) {
        return PLAYER2;
    }
    for ($i = 0; $i < count($hand1['sortCardRanks']); $i++) {
        if ($hand1['sortCardRanks'][$i] > $hand2['sortCardRanks'][$i]) {
            return PLAYER1;
        } elseif ($hand1['sortCardRanks'][$i] < $hand2['sortCardRanks'][$i]) {
            return PLAYER2;
        }
    }
    return DRAW;
}

function groupPlayer(string $p1_1, string $p1_2, string $p2_1, string $p2_2): array
{
    $playerData = [
        PLAYER1 => [
            'card' => [
                0 => replaceJQKA($p1_1),
                1 => replaceJQKA($p1_2),
            ],
            'role' => 0
        ],
        PLAYER2 => [
            'card' => [
                0 => replaceJQKA($p2_1),
                1 => replaceJQKA($p2_2),
            ],
            'role' => 0
        ],
    ];

    return $playerData;
}

function replaceJQKA(string $card): int
{
    $card = substr($card, 1);
    switch ($card) {
        case 'J':
            return J;
        case 'Q':
            return Q;
        case 'K':
            return K;
        case 'A':
            return A;
        default:
            return intval($card);
    }
    return intval($card);
}

function checkPokerRole(array $playerData): array
{
    foreach ($playerData as &$player) {
        if (isPair($player)) {
            $player['role'] = array_search('pair', ROLE);
        } elseif (isStraight($player)) {
            $player['role'] = array_search('straight', ROLE);
        } else {
            $player['role'] = array_search('high card', ROLE);
        }
    }
    unset($player);
    return $playerData;
}

function judge(array $playerData): int
{
    $result = 0;
    if ($playerData[PLAYER1]['role'] > $playerData[PLAYER2]['role']) {
        return $result = PLAYER1;
    } elseif ($playerData[PLAYER1]['role'] < $playerData[PLAYER2]['role']) {
        return PLAYER2;
    } elseif ($playerData[PLAYER1]['role'] === $playerData[PLAYER2]['role']) {
        switch ($playerData[PLAYER1]['role']) {
            case 0:
                return compareHighCardNum($playerData);
            case 1:
                return comparePairNum($playerData);
            case 2:
                return compareStraightNum($playerData);
            default:
                return DRAW;
        }
    } else {
        return DRAW;
    }



    return [ROLE[$playerData[PLAYER1]['role']], ROLE[$playerData[PLAYER2]['role']], $result];
}

function compareHighCardNum(array $playerData): int
{
    if (max($playerData[PLAYER1]['card']) > max($playerData[PLAYER2]['card'])) {
        return PLAYER1;
    } elseif (max($playerData[PLAYER1]['card']) < max($playerData[PLAYER2]['card'])) {
        return PLAYER2;
    } elseif (min($playerData[PLAYER1]['card']) > min($playerData[PLAYER2]['card'])) {
        return PLAYER1;
    } elseif (min($playerData[PLAYER1]['card']) < min($playerData[PLAYER2]['card'])) {
        return PLAYER2;
    } else {
        return DRAW;
    }
}

function comparePairNum(array $playerData): int
{
    if ($playerData[PLAYER1]['card'][0] > $playerData[PLAYER2]['card'][0])
        return PLAYER1;
    elseif ($playerData[PLAYER1]['card'][0] < $playerData[PLAYER2]['card'][0])
        return PLAYER2;
    else {
        return DRAW;
    }
}

function compareStraightNum(array $playerData): int
{
    if ((count(array_intersect(KA, $playerData[PLAYER1]['card'])) == count(KA)) && (count(array_intersect(A2, $playerData[PLAYER2]['card'])) == count(A2))) {
        return PLAYER1;
    } elseif ((count(array_intersect(A2, $playerData[PLAYER1]['card'])) == count(A2)) && (count(array_intersect(KA, $playerData[PLAYER2]['card'])) == count(KA))) {
        return PLAYER2;
    } elseif ((count(array_intersect([2, 3], $playerData[PLAYER1]['card'])) == count([2, 3])) && (count(array_intersect(A2, $playerData[PLAYER2]['card'])) == count(A2))) {
        return PLAYER1;
    } elseif ((count(array_intersect(A2, $playerData[PLAYER1]['card'])) == count(A2)) && (count(array_intersect([2, 3], $playerData[PLAYER2]['card'])) == count([2, 3]))) {
        return PLAYER2;
    } elseif (min($playerData[PLAYER1]['card']) > min($playerData[PLAYER2]['card'])) {
        return PLAYER1;
    } elseif (min($playerData[PLAYER1]['card']) < min($playerData[PLAYER2]['card'])) {
        return PLAYER2;
    } else {
        return DRAW;
    }
}

function showDown(string $p1_1, string $p1_2, string $p2_1, string $p2_2): array
{
    $playerData = groupPlayer($p1_1, $p1_2, $p2_1, $p2_2);
    $playerData = checkPokerRole($playerData);
    $winner = judge($playerData);
    return [ROLE[$playerData[PLAYER1]['role']], ROLE[$playerData[PLAYER2]['role']], $winner];
}
