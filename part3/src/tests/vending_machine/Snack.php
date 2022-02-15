<?php

declare(strict_types=1);

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\Snack;

require_once __DIR__ . '/../../lib/vending_machine/Snack.php';

final class SnackTest extends TestCase
{
    public function testGetSnackName(): void
    {
        $Snack = new Snack('potato chips');
        $this->assertSame('potato chips', $Snack->getName());
    }

    public function testGetSnackPrice(): void
    {
        $Snack = new Snack('potato chips');
        $this->assertSame(150, $Snack->getPrice());
    }

    public function testGetCupNumber(): void
    {
        $Snack = new Snack('potato chips');
        $this->assertSame(0, $Snack->getCupNumber());
    }
}
