<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../lib/convertToNumber.php';

final class HITandBLOWTest extends TestCase
{
    public function test(): void
    {
        $this->assertSame(['7'], convertToNumber('C7'));
        $this->assertSame(['3', '10', 'A'], convertToNumber('H3', 'S10', 'DA'));
    }
}
