<?php

namespace Poker;

class PokerHandEvaluator
{
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';
    private const THREE_OF_A_KIND = 'three card';
    private const HIGH_CARD = 'high card';
    private const HAND_RANKS = [
        self::HIGH_CARD       => 0,
        self::PAIR            => 1,
        self::STRAIGHT        => 2,
        self::THREE_OF_A_KIND => 3,
    ];

    public function __construct(private $rule)
    {
    }

    public function getHand(array $cards): string
    {
        return $this->rule->getHand($cards);
    }

    public function getWinner(array $cards, array $hands): int
    {
        if (self::HAND_RANKS[$hands[0]] > self::HAND_RANKS[$hands[1]]) {
            return 1;
        } elseif (self::HAND_RANKS[$hands[0]] < self::HAND_RANKS[$hands[1]]) {
            return 2;
        } elseif (($hands[0] === self::PAIR) && ($hands[1] === self::PAIR)) {
            return $this->comparePair($cards);
        } else {
            rsort($cards[0]);
            rsort($cards[1]);
            for ($i = 0; $i < count($cards[0]); $i++) {
                if ($cards[0][$i] > $cards[1][$i]) {
                    return 1;
                } elseif ($cards[0][$i] < $cards[1][$i]) {
                    return 2;
                }
            }
            return 0;
        }
    }

    private function comparePair(array $cards): int
    {
        $cardNum = [];
        foreach ($cards as $card) {
            for ($i = 0; $i < count($card) - 1; $i++) {
                for ($j = $i + 1; $j < count($card); $j++) {
                    if ($card[$i] === $card[$j]) {
                        $cardNum[] = $card[$i];
                        break;
                    }
                }
            }
        }

        if ($cardNum[0] > $cardNum[1]) {
            return 1;
        } elseif ($cardNum[0] < $cardNum[1]) {
            return 2;
        }

        return 0;
    }
}
