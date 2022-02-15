<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../lib/calculateMarket.php';

final class CalculateSalesTest extends TestCase
{
    public function test(): void
    {
        $this->assertSame(1298, calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]));
    }
}
