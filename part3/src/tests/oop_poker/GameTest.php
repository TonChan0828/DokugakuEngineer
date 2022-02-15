<?php

declare(strict_types=1);

namespace OopPoker\Tests;

use PHPUnit\Framework\TestCase;
use OopPoker\Game;

require_once __DIR__ . '/../../lib/oop_poker/Game.php';

final class GameTest extends TestCase
{
    public function testStart(): void
    {
        $game = new Game('田中', '松本', 2, 'A');
        $result = $game->start();
        $this->assertSame(1, $result);
    }
}
