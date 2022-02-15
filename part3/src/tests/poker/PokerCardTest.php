<?php

declare(strict_types=1);

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\PokerCard;

require_once __DIR__ . '/../../lib/poker/PokerCard.php';

final class PokerCardTest extends TestCase
{
    public function testGetRank(): void
    {
        $card = new PokerCard('CA');
        $this->assertSame(13, $card->getRank());
    }
}
