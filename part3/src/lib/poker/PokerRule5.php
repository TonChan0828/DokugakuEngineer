<?php

namespace Poker;

require_once('PokerRule.php');
require_once('PokerCard.php');

class PokerRule5 implements PokerRule
{
    private const PAIR = 'pair';
    private const TWO_PAIR = 'two pair';
    private const STRAIGHT = 'straight';
    private const THREE_OF_A_KIND = 'three of a kind';
    private const A_FULL_HOUSE = 'a full house';
    private const FOUR_OF_A_KIND = 'four of a kind';
    private const HIGH_CARD = 'high card';

    public function __construct()
    {
    }
    public function getHand(array $cards): string
    {
        if ($this->isFourCard($cards)) {
            return self::FOUR_OF_A_KIND;
        } elseif ($this->isFullHouse($cards)) {
            return self::A_FULL_HOUSE;
        } elseif ($this->isThreeCard($cards)) {
            return self::THREE_OF_A_KIND;
        } elseif ($this->isTwoPair($cards)) {
            return self::TWO_PAIR;
        } elseif ($this->isPair($cards)) {
            return self::PAIR;
        } elseif ($this->isStraight($cards)) {
            return self::STRAIGHT;
        }
        return self::HIGH_CARD;
    }

    private function isFourCard(array $cards): bool
    {
        foreach ($cards as $card) {
            if (count(array_keys($cards, $card)) === 4) {
                return true;
            }
        }
        return false;
    }

    private function isFullHouse(array $cards): bool
    {
        if ($this->isThreeCard($cards) && $this->isPair($cards)) {
            return true;
        } else {
            return false;
        }
    }

    private function isThreeCard(array $cards): bool
    {
        foreach ($cards as $card) {
            if (count(array_keys($cards, $card)) === 3) {
                return true;
            }
        }
        return false;
    }

    private function isPair(array $cards): bool
    {
        foreach ($cards as $card) {
            if (count(array_keys($cards, $card)) === 2) {
                return true;
            }
        }
        return false;
    }

    private function isTwoPair(array $cards): bool
    {
        $pairCount = [];
        foreach ($cards as $card) {
            if (count(array_keys($cards, $card)) === 2) {
                if (count(array_keys($pairCount, $card)) === 0) {
                    $pairCount[] = $card;
                }
            }
        }
        if (count($pairCount) === 2) {
            return true;
        } else {
            return false;
        }
    }

    private function isStraight(array $cards): bool
    {
        rsort($cards);
        return (($cards[0] - end($cards)) === (count($cards) - 1)) || $this->isFirstStraight($cards);
    }

    private function isFirstStraight(array $cards): bool
    {
        return $cards === [max(PokerCard::CARD_RANK), min(PokerCard::CARD_RANK) + 3, min(PokerCard::CARD_RANK) + 2, min(PokerCard::CARD_RANK) + 1, min(PokerCard::CARD_RANK)];
    }
}
