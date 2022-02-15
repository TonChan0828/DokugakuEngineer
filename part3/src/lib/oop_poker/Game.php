<?php

namespace OopPoker;

require_once('Player.php');
require_once('Deck.php');
require_once('HandEvaluator.php');
require_once('RuleA.php');
require_once('RuleB.php');
require_once('RuleC.php');

class Game
{
    public function __construct(private string $name1, private string $name2, private int $drawNum, private string $ruleType)
    {
    }

    public function start()
    {
        $deck = new Deck();
        $rule = $this->getRule();
        $handEvaluator = new HandEvaluator($rule);
        $hand = [];

        foreach ([$this->name1, $this->name2] as $name) {
            //プレイヤーを登録する
            $player = new Player($name);
            //プレイヤーがカードを引く
            $cards = $player->drawCards($deck, $this->drawNum);
            $hand = $handEvaluator->getHand($cards);
        }
        return HandEvaluator::getWinner($hand[0], $hand[1]);
    }

    private function getRule()
    {
        if ($this->ruleType === 'A') {
            return new RuleA();
        } elseif ($this->ruleType === 'B') {
            return new RuleB();
        } elseif ($this->ruleType === 'C') {
            return new RuleC();
        }
    }
}
