<?php

declare(strict_types=1);

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Card;
use OopPoker\HandEvaluator;
use OopPoker\RuleA;

require_once __DIR__ . '/../../lib/oop_poker/HandEvaluator.php';
require_once __DIR__ . '/../../lib/oop_poker/RuleA.php';
require_once __DIR__ . '/../../lib/oop_poker/Card.php';

final class HandEvaluatorTest extends TestCase
{
    public function testGetHand(): void
    {
        $handEvaluator = new HandEvaluator(new RuleA());
        $cards = [new Card('H', 10), new Card('C', 10)];
        $this->assertSame('pair', $handEvaluator->getHand($cards));
    }

    public function TestGetWinner()
    {
        $this->assertSame(1, HandEvaluator::getWinner('pair', 'high card'));
    }
}
