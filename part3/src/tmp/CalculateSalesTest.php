<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../lib/CalculateSales.php';

final class CalculateSalesTest extends TestCase
{
    public function test(): void
    {
        $output = <<< EOT
        1573
        1
        2 3 7

        EOT;
        $this->expectOutputString($output);

        $inputs = Input(['file', '1', '10', '2', '3', '5', '1', '7', '5', '10', '1']);
        $items = groupItems($inputs);
        $total = calculateSales($items);
        $max = searchMaxSaleItem($items);
        $min = searchMinSaleItem($items);
        display($total, $max, $min);
    }
}
