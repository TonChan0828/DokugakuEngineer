<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../lib/CardPoker.php';

final class CardPokerTest extends TestCase
{
    public function test(): void
    {
        //2枚
        $this->assertSame(['high card', 'pair', 2],      showResult(['CK', 'DJ'], ['C10', 'H10']));
        $this->assertSame(['high card', 'straight', 2],  showResult(['CK', 'DJ'], ['C3', 'H4']));
        $this->assertSame(['straight', 'pair', 1],       showResult(['C3', 'H4'], ['DK', 'SK']));
        $this->assertSame(['high card', 'high card', 1], showResult(['HJ', 'SK'], ['DQ', 'D10']));
        $this->assertSame(['high card', 'high card', 2], showResult(['H9', 'SK'], ['DK', 'D10']));
        $this->assertSame(['high card', 'high card', 0], showResult(['H3', 'S5'], ['D5', 'D3']));
        $this->assertSame(['pair', 'pair', 1],           showResult(['CA', 'DA'], ['C2', 'D2']));
        $this->assertSame(['pair', 'pair', 2],           showResult(['CK', 'DK'], ['CA', 'DA']));
        $this->assertSame(['pair', 'pair', 0],           showResult(['C4', 'D4'], ['H4', 'S4']));
        $this->assertSame(['straight', 'straight', 1],   showResult(['SA', 'DK'], ['C2', 'CA']));
        $this->assertSame(['straight', 'straight', 2],   showResult(['C2', 'CA'], ['S2', 'D3']));
        $this->assertSame(['straight', 'straight', 0],   showResult(['S2', 'D3'], ['C2', 'H3']));

        //3枚
        $this->assertSame(['high card', 'pair', 2],        showResult(['CK', 'DJ', 'H9'], ['C10', 'H10', 'D3']));
        $this->assertSame(['high card', 'straight', 2],    showResult(['CK', 'DA', 'H2'], ['C3', 'H4', 'S5']));
        $this->assertSame(['high card', 'three card', 2],  showResult(['CK', 'DJ', 'H9'], ['C3', 'H3', 'S3']));
        $this->assertSame(['straight', 'pair', 1],         showResult(['C3', 'H4', 'S5'], ['DK', 'SK', 'D10']));
        $this->assertSame(['three card', 'pair', 1],       showResult(['C3', 'H3', 'S3'], ['DK', 'SK', 'D10']));
        $this->assertSame(['three card', 'straight', 1],   showResult(['C3', 'H3', 'S3'], ['DK', 'SJ', 'DQ']));
        $this->assertSame(['high card', 'high card', 1],   showResult(['HJ', 'SK', 'D9'], ['DQ', 'D10', 'H8']));
        $this->assertSame(['high card', 'high card', 2],   showResult(['H9', 'SK', 'H7'], ['DK', 'D10', 'H5']));
        $this->assertSame(['high card', 'high card', 1],   showResult(['H9', 'SK', 'H7'], ['DK', 'D9', 'H5']));
        $this->assertSame(['high card', 'high card', 0],   showResult(['H3', 'S5', 'C7'], ['D5', 'S7', 'D3']));
        $this->assertSame(['pair', 'pair', 1],             showResult(['CA', 'DA', 'DK'], ['C2', 'D2', 'C3']));
        $this->assertSame(['pair', 'pair', 2],             showResult(['CK', 'DK', 'SA'], ['CA', 'DA', 'SK']));
        $this->assertSame(['pair', 'pair', 1],             showResult(['C4', 'D4', 'S7'], ['H4', 'S4', 'C6']));
        $this->assertSame(['pair', 'pair', 0],             showResult(['C4', 'D4', 'S7'], ['H4', 'S4', 'C7']));
        $this->assertSame(['straight', 'straight', 1],     showResult(['SA', 'DK', 'DQ'], ['CA', 'C2', 'D3']));
        $this->assertSame(['straight', 'straight', 1],     showResult(['SA', 'DK', 'DQ'], ['CK', 'CQ', 'DJ']));
        $this->assertSame(['straight', 'straight', 1],     showResult(['S2', 'H3', 'D4'], ['CA', 'C2', 'D3']));
        $this->assertSame(['straight', 'straight', 0],     showResult(['S2', 'S3', 'S4'], ['C2', 'C3', 'D4']));
        $this->assertSame(['three card', 'three card', 2], showResult(['S2', 'C2', 'D2'], ['CA', 'HA', 'SA']));
        $this->assertSame(['three card', 'three card', 2], showResult(['SK', 'CK', 'DK'], ['CA', 'HA', 'SA']));
        $this->assertSame(['three card', 'three card', 2], showResult(['S2', 'C2', 'D2'], ['C3', 'H3', 'S3']));
    }
}

/*
// カード2枚ずつの場合
showResult(['CK', 'DJ'], ['C10', 'H10'])  //=> ['high card', 'pair', 2]
showResult(['CK', 'DJ'], ['C3', 'H4'])    //=> ['high card', 'straight', 2]
showResult(['C3', 'H4'], ['DK', 'SK'])    //=> ['straight', 'pair', 1]
showResult(['HJ', 'SK'], ['DQ', 'D10'])   //=> ['high card', 'high card', 1]
showResult(['H9', 'SK'], ['DK', 'D10'])   //=> ['high card', 'high card', 2]
showResult(['H3', 'S5'], ['D5', 'D3'])    //=> ['high card', 'high card', 0]
showResult(['CA', 'DA'], ['C2', 'D2'])    //=> ['pair', 'pair', 1]
showResult(['CK', 'DK'], ['CA', 'DA'])    //=> ['pair', 'pair', 2]
showResult(['C4', 'D4'], ['H4', 'S4'])    //=> ['pair', 'pair', 0]
showResult(['SA', 'DK'], ['C2', 'CA'])    //=> ['straight', 'straight', 1]
showResult(['C2', 'CA'], ['S2', 'D3'])    //=> ['straight', 'straight', 2]
showResult(['S2', 'D3'], ['C2', 'H3'])    //=> ['straight', 'straight', 0]

// カード3枚ずつの場合
showResult(['CK', 'DJ', 'H9'], '[C10', 'H10', 'D3'])  //=> ['high card', 'pair', 2]
showResult(['CK', 'DA', 'H2'], '[C3', 'H4', 'S5'])     //=> ['high card', 'straight', 2]
showResult(['CK', 'DJ', 'H9'], '[C3', 'H3', 'S3'])     //=> ['high card', 'three card', 2]
showResult(['C3', 'H4', 'S5'], '[DK', 'SK', 'D10'])    //=> ['straight', 'pair', 1]
showResult(['C3', 'H3', 'S3'], '[DK', 'SK', 'D10'])    //=> ['three card', 'pair', 1]
showResult(['C3', 'H3', 'S3'], '[DK', 'SJ', 'DQ'])     //=> ['three card', 'straight', 1]
showResult(['HJ', 'SK', 'D9'], '[DQ', 'D10', 'H8'])    //=> ['high card', 'high card', 1]
showResult(['H9', 'SK', 'H7'], '[DK', 'D10', 'H5'])    //=> ['high card', 'high card', 2]
showResult(['H9', 'SK', 'H7'], '[DK', 'D9', 'H5'])     //=> ['high card', 'high card', 1]
showResult(['H3', 'S5', 'C7'], '[D5', 'S7', 'D3'])     //=> ['high card', 'high card', 0]
showResult(['CA', 'DA', 'DK'], '[C2', 'D2', 'C3'])     //=> ['pair', 'pair', 1]
showResult(['CK', 'DK', 'SA'], '[CA', 'DA', 'SK'])     //=> ['pair', 'pair', 2]
showResult(['C4', 'D4', 'S7'], '[H4', 'S4', 'C6'])     //=> ['pair', 'pair', 1]
showResult(['C4', 'D4', 'S7'], '[H4', 'S4', 'C7'])     //=> ['pair', 'pair', 0]
showResult(['SA', 'DK', 'DQ'], '[CA', 'C2', 'D3'])     //=> ['straight', 'straight', 1]
showResult(['SA', 'DK', 'DQ'], '[CK', 'CQ', 'DJ'])     //=> ['straight', 'straight', 1]
showResult(['S2', 'H3', 'D4'], '[CA', 'C2', 'D3'])     //=> ['straight', 'straight', 1]
showResult(['S2', 'S3', 'S4'], '[C2', 'C3', 'D4'])     //=> ['straight', 'straight', 0]
showResult(['S2', 'C2', 'D2'], '[CA', 'HA', 'SA'])     //=> ['three card', 'three card', 2]
showResult(['SK', 'CK', 'DK'], '[CA', 'HA', 'SA'])     //=> ['three card', 'three card', 2]
showResult(['S2', 'C2', 'D2'], '[C3', 'H3', 'S3'])     //=> ['three card', 'three card', 2]
*/
