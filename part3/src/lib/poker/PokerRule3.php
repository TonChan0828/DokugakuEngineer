<?php

namespace Poker;

require_once('PokerRule.php');

class PokerRule3 implements PokerRule
{
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';
    private const THREE_OF_A_KIND = 'three card';
    private const HIGH_CARD = 'high card';

    public function __construct()
    {
    }
    public function getHand(array $cards): string
    {
        if ($this->isThreeCard($cards)) {
            return self::THREE_OF_A_KIND;
        } elseif ($this->isPair($cards)) {
            return self::PAIR;
        } elseif ($this->isStraight($cards)) {
            return self::STRAIGHT;
        }
        return self::HIGH_CARD;
    }

    private function isThreeCard(array $cards): bool
    {
        return (count(array_keys($cards, $cards[0])) === 3);
    }

    private function isPair(array $cards): bool
    {
        for ($i = 0; $i < count($cards); $i++) {
            for ($j = $i + 1; $j < count($cards); $j++) {
                if ($cards[$i] === $cards[$j]) {
                    return true;
                }
            }
        }
        return false;
    }

    private function isStraight(array $cards): bool
    {
        rsort($cards);
        for ($i = 0; $i < count($cards) - 2; $i++) {
            if (((abs($cards[$i + 2] - $cards[$i + 1]) === 1) && (abs($cards[$i + 1] - $cards[$i])) === 1) ||
                ((abs($cards[$i] - $cards[$i + 2]) === 12) && (abs($cards[$i + 1] - $cards[$i + 2]) === 1))
            ) {
                return true;
            }
        }
        return false;
    }
}
