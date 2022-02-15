<?php

declare(strict_types=1);


namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\CupDrink;
use VendingMachine\VendingMachine;

require_once __DIR__ . '/../../lib/vending_machine/CupDrink.php';

final class CupDrinkTest extends TestCase
{
    public function testGetDrinkName(): void
    {
        $drink = new CupDrink('hot cup coffee');
        $this->assertSame('hot cup coffee', $drink->getName());
    }

    public function testGetDrinkPrice(): void
    {
        $drink = new CupDrink('hot cup coffee');
        $vendingMachine = new VendingMachine();
        $this->assertSame(100, $drink->getPrice());
    }

    public function testGetCupNumber(): void
    {
        $drink = new CupDrink('hot cup coffee');
        $this->assertSame(1, $drink->getCupNumber());
    }
}
