<?php

declare(strict_types=1);

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\PokerRule5;

require_once __DIR__ . '/../../lib/poker/PokerRule5.php';

final class PokerRule5Test extends TestCase
{
    public function testGetHand(): void
    {
        $rule = new PokerRule5();
        $this->assertSame('pair', $rule->getHand([13, 7, 2, 5, 7]));
        $this->assertSame('two pair', $rule->getHand([13, 13, 2, 2, 7]));
        $this->assertSame('three of a kind', $rule->getHand([13, 13, 13, 5, 7]));
        $this->assertSame('four of a kind', $rule->getHand([13, 13, 13, 13, 7]));
        $this->assertSame('a full house', $rule->getHand([13, 13, 2, 2, 2]));
        $this->assertSame('straight', $rule->getHand([13, 12, 11, 10, 9]));
        $this->assertSame('straight', $rule->getHand([13, 1, 2, 3, 4]));
        $this->assertSame('high card', $rule->getHand([1, 2, 3, 12, 13]));
    }
}
