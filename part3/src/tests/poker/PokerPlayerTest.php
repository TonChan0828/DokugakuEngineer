<?php

declare(strict_types=1);

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use Poker\PokerPlayer;
use Poker\PokerCard;

require_once(__DIR__ . '/../../lib/poker/PokerPlayer.php');
require_once(__DIR__ . '/../../lib/poker/PokerCard.php');

final class PokerPlayerTest extends TestCase
{
    public function testGetCardRanks(): void
    {
        $player = new PokerPlayer([new PokerCard('CA'), new PokerCard('D10')]);
        $this->assertSame([13, 9], $player->getCardRanks());
    }
}
