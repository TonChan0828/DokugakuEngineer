<?php

declare(strict_types=1);

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Card;
use OopPoker\RuleB;

require_once __DIR__ . '/../../lib/oop_poker/RuleB.php';


final class RuleBTest extends TestCase
{
    public function testGetHand(): void
    {
        $rule = new RuleB();
        $cards = [new Card('H', 10), new Card('C', 10)];
        $this->assertSame('high card', $rule->getHand($cards));
    }
}
