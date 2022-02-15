<?php

declare(strict_types=1);

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Card;
use OopPoker\RuleC;

require_once __DIR__ . '/../../lib/oop_poker/RuleC.php';


final class RuleCTest extends TestCase
{
    public function testGetHand(): void
    {
        $rule = new RuleC();
        $cards = [new Card('H', 10), new Card('C', 10)];
        $this->assertSame('straight', $rule->getHand($cards));
    }
}
