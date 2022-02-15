<?php

/*
機能
売り上げの合計
販売戸数の最も多い商品番号
販売戸数の最も少ない商品番号

パーツ
▲商品価格対応表
▲消費税
入力取得
売り上げ計算
個数計算
表示
*/

const PRICE_TABLE = [
    '1'  => 100,
    '2'  => 120,
    '3'  => 150,
    '4'  => 250,
    '5'  => 80,
    '6'  => 120,
    '7'  => 100,
    '8'  => 180,
    '9'  => 50,
    '10' => 300,
];
const TAX = 0.1;

function Input(array $argv): array
{
    return array_slice($argv, 1);
}

function groupItems(array $inputs): array
{
    $items = [];
    foreach ($inputs as $input) {
        if (array_key_exists($input, $items)) {
            $items[$input]++;
        } else {
            $items[$input] = 1;
        }
    }
    return $items;
}

function calculateSales(array $items): int
{
    $totalSales = 0;
    foreach ($items as $key => $val) {
        $totalSales += (PRICE_TABLE[$key] * $val);
    }
    return $totalSales * (1 + TAX);
}

function searchMinSaleItem(array $items): array
{
    if (empty($items)) { // テスト実行時にエラーが起きないよう、入力が空の時でも動作するよう処理を追加
        return [];
    }
    return array_keys($items, min(array_values($items)));
}

function searchMaxSaleItem(array $items): array
{
    if (empty($items)) { // テスト実行時にエラーが起きないよう、入力が空の時でも動作するよう処理を追加
        return [];
    }
    return array_keys($items, max(array_values($items)));
}

function display(int $sale, array $max, array $min): void
{
    echo $sale . PHP_EOL;
    echo implode(' ', $max) . PHP_EOL;
    echo implode(' ', $min) . PHP_EOL;
}

$inputs = Input($_SERVER['argv']);
$items = groupItems($inputs);
$total = calculateSales($items);
$max = searchMaxSaleItem($items);
$min = searchMinSaleItem($items);
display($total, $max, $min);
