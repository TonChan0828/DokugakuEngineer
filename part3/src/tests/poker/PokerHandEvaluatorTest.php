<?php

declare(strict_types=1);

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\PokerGame;
use Poker\PokerHandEvaluator;
use Poker\PokerRule2;
use Poker\PokerRule3;

require_once __DIR__ . '/../../lib/poker/PokerHandEvaluator.php';

class PokerHandEvaluatorTest extends TestCase
{
    public function testGetWinner()
    {
        // カードが2枚の場合
        $game1 = new PokerHandEvaluator(new PokerRule2());
        $this->assertSame(2, $game1->getWinner([[5, 5], [2, 3]], ['pair', 'straight']));
        $this->assertSame(1, $game1->getWinner([[5, 5], [2, 2]], ['pair', 'pair']));
        $this->assertSame(1, $game1->getWinner([[5, 5], [2, 8]], ['pair', 'high card']));
        $this->assertSame(2, $game1->getWinner([[1, 2], [13, 1]], ['straight', 'straight']));
        $this->assertSame(2, $game1->getWinner([[1, 5], [13, 1]], ['high card', 'straight']));
        $this->assertSame(2, $game1->getWinner([[1, 3], [12, 2]], ['high card', 'high card']));
        $this->assertSame(0, $game1->getWinner([[12, 2], [12, 2]], ['high card', 'high card']));

        // カードが3枚の場合
        $game2 = new PokerHandEvaluator(new PokerRule3());
        $this->assertSame(1, $game2->getWinner([[5, 5, 5], [2, 2, 2]], ['three card', 'three card']));
        $this->assertSame(1, $game2->getWinner([[5, 5, 3], [2, 2, 6]], ['pair', 'pair']));
        $this->assertSame(2, $game2->getWinner([[1, 2, 3], [13, 1, 2]], ['straight', 'straight']));
        $this->assertSame(2, $game2->getWinner([[1, 3, 7], [12, 2, 8]], ['high card', 'high card']));
        $this->assertSame(0, $game2->getWinner([[12, 2, 9], [12, 2, 9]], ['high card', 'high card']));
    }
}
