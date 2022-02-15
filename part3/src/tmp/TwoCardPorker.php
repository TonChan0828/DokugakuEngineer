<?php

/*
カードを判定する
役を判定する
勝敗を判定する
*/

use phpDocumentor\Reflection\Types\Boolean;

const ROLE = ['high card', 'pair', 'straight'];
const PLAYER1 = 1;
const PLAYER2 = 2;
const DRAW    = 0;
const J = 11;
const Q = 12;
const K = 13;
const A = 14;
const KA = [13, 14];
const A2 = [2, 14];

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

function isPair(array $player): bool
{
    return $player['card'][0] === $player['card'][1];
}

function isStraight(array $player): bool
{
    if ((abs($player['card'][0] - $player['card'][1]) === 1) || (abs($player['card'][0] - $player['card'][1]) === 12)) {
        return true;
    } else {
        return false;
    }
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


showDown('C2', 'CA', 'S2', 'D3');
