<?php

declare(strict_types=1);

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Deck;
use OopPoker\Player;

require_once __DIR__ . '/../../lib/oop_poker/Player.php';

final class PlayerTest extends TestCase
{
    public function testDrawCards(): void
    {
        $deck = new Deck();
        $player = new Player('田中');
        $cards = $player->drawCards($deck, 2);
        $this->assertSame(2, count($cards));
    }
}
