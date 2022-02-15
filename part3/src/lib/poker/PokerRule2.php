<?php

namespace Poker;

require_once('PokerRule.php');

class PokerRule2 implements PokerRule
{
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';
    private const HIGH_CARD = 'high card';


    public function __construct()
    {
    }
    public function getHand(array $cards): string
    {
        if ($this->isPair($cards)) {
            return self::PAIR;
        } elseif ($this->isStraight($cards)) {
            return self::STRAIGHT;
        }
        return self::HIGH_CARD;
    }

    private function isPair(array $cards): bool
    {
        if ($cards[0] === $cards[1]) {
            return true;
        } else {
            return false;
        }
    }

    private function isStraight(array $cards): bool
    {
        if ((abs($cards[0] - $cards[1]) === 1) || (abs($cards[0] - $cards[1]) === 12)) {
            return true;
        } else {
            return false;
        }
    }
}
