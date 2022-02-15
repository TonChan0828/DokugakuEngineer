<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../lib/Viewing.php';

final class ViewingTest extends TestCase
{
    public function test(): void
    {
        $output = <<< EOT
        1.7
        1 45 2
        5 25 1
        2 30 1

        EOT;
        $this->expectOutputString($output);

        $inputs = Inputs(['file', '1', '30', '5', '25', '2', '30', '1', '15']);
        $viewingChannelPeriods = groupChannelViewingPeriods($inputs);
        displays($viewingChannelPeriods);
    }
}
