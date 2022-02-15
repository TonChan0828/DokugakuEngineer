<?php

declare(strict_types=1);

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Card;
use OopPoker\RuleA;

require_once __DIR__ . '/../../lib/oop_poker/RuleA.php';


final class RuleATest extends TestCase
{
    public function testGetHand(): void
    {
        $rule = new RuleA();
        $cards = [new Card('H', 10), new Card('C', 10)];
        $this->assertSame('pair', $rule->getHand($cards));
    }
}
