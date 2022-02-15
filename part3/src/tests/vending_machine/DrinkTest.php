<?php

declare(strict_types=1);

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\Drink;

require_once __DIR__ . '/../../lib/vending_machine/Drink.php';

final class DrinkTest extends TestCase
{
    public function testGetDrinkName(): void
    {
        $drink = new Drink('cola');
        $this->assertSame('cola', $drink->getName());
    }

    public function testGetDrinkPrice(): void
    {
        $drink = new Drink('cola');
        $this->assertSame(150, $drink->getPrice());
    }

    public function testGetCupNumber(): void
    {
        $drink = new Drink('cola');
        $this->assertSame(0, $drink->getCupNumber());
    }
}
