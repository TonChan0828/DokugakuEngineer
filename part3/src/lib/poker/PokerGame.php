<?php

namespace Poker;

require_once(__DIR__ . '/PokerPlayer.php');
require_once(__DIR__ . '/PokerCard.php');
require_once(__DIR__ . '/PokerRule2.php');
require_once(__DIR__ . '/PokerRule3.php');
require_once(__DIR__ . '/PokerRule5.php');
require_once(__DIR__ . '/PokerHandEvaluator.php');

class PokerGame
{
    public function __construct(private array $cards1, private array $cards2)
    {
    }
    public function start()
    {
        $playerCardRanks = [];
        foreach ([$this->cards1, $this->cards2] as $cards) {
            $pokerCards = array_map(fn ($card) => new PokerCard($card), $cards);
            $player = new PokerPlayer($pokerCards);
            $playerCardRanks[] = $player->getCardRanks();
        }
        $rule = $this->getRule();
        $pokerHandEvaluator = new PokerHandEvaluator($rule);
        $hands = array_map(fn ($playerCardRank) => $pokerHandEvaluator->getHand($playerCardRank), $playerCardRanks);
        $winner = $pokerHandEvaluator->getWinner($playerCardRanks, $hands);
        return [$hands[0], $hands[1], $winner];
    }

    public function getRule()
    {
        if (count($this->cards1) === 2) {
            return new PokerRule2();
        } elseif (count($this->cards1) === 3) {
            return new PokerRule3();
        } elseif (count($this->cards1) === 5) {
            return new PokerRule5();
        }
    }
}
