<?php

declare(strict_types=1);

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\PokerRule2;

require_once __DIR__ . '/../../lib/poker/PokerRule2.php';

final class PokerRule2Test extends TestCase
{
    public function testGetHand(): void
    {
        $rule = new PokerRule2();
        $this->assertSame('pair', $rule->getHand([13, 13]));
        $this->assertSame('straight', $rule->getHand([3, 2]));
    }
}
