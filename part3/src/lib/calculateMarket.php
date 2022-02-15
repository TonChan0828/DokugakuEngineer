<?php

/*
必要なし）入力値を配列に格納する
商品を分けて購入商品の個数と入店時間がわかる連想配列に格納
合計金額を求める
対象商品購入時の割引を行う
▲表示する
*/

const TAX = 0.1;
const PRICE_TABLE = [
    1 => [
        'name'  => '玉ねぎ',
        'price' => 100,
        'type'  => ''
    ],
    2 => [
        'name'  => '人参',
        'price' => 150,
        'type'  => ''
    ],
    3 => [
        'name'  => 'りんご',
        'price' => 200,
        'type'  => ''
    ],
    4 => [
        'name'  => 'ぶどう',
        'price' => 350,
        'type'  => ''
    ],
    5 => [
        'name'  => '牛乳',
        'price' => 180,
        'type'  => 'drink'
    ],
    6 => [
        'name'  => '卵',
        'price' => 220,
        'type'  => ''
    ],
    7 => [
        'name'  => '唐揚げ弁当',
        'price' => 440,
        'type'  => 'bento'
    ],
    8 => [
        'name'  => 'のり弁',
        'price' => 380,
        'type'  => 'bento'
    ],
    9 => [
        'name'  => 'お茶',
        'price' => 80,
        'type'  => 'drink'
    ],
    10 => [
        'name'  => 'コーヒー',
        'price' => 100,
        'type'  => 'drink'
    ]
];

const FIRST_ONION_DISCOUNT_NUMBER = 3;
const FIRST_ONION_DISCOUNT_PRICE  = 50;
const SECOND_ONION_DISCOUNT_NUMBER = 5;
const SECOND_ONION_DISCOUNT_PRICE  = 100;
const SET_DISCOUNT_PRICE = 20;
const BENTO_DISCOUNT_START_TIME = '20:00';
const BENTO_DISCOUNT_END_TIME   = '23:00';

function regroupItems(array $inputs): array
{
    $items = [];
    foreach ($inputs as $input) {
        if (!array_key_exists($input, $items)) {
            $items[$input] = 0;
        }
        $items[$input]++;
    }
    return $items;
}



function discount(array $items, string $time): int
{
    //玉ねぎの値引き
    $discount = 0;
    if (array_key_exists(1, $items) && $items[1] >= SECOND_ONION_DISCOUNT_NUMBER) {
        $discount += SECOND_ONION_DISCOUNT_PRICE;
    } elseif (array_key_exists(1, $items) && $items[1] >= FIRST_ONION_DISCOUNT_NUMBER) {
        $discount += FIRST_ONION_DISCOUNT_PRICE;
    }

    //飲み物と弁当同時購入による値引き
    $countDrink = 0;
    foreach ($items as $key => $val) {
        if (PRICE_TABLE[$key]['type'] === 'drink') {
            $countDrink += $val;
        }
    }
    $countBento = 0;
    foreach ($items as $key => $val) {
        if (PRICE_TABLE[$key]['type'] === 'bento') {
            $countBento += $val;
        }
    }
    $discount += (SET_DISCOUNT_PRICE * min($countDrink, $countBento));

    //20~23時の弁当タイムセール
    $time = strtotime($time);
    if ($time >= strtotime(BENTO_DISCOUNT_START_TIME) && $time <= strtotime(BENTO_DISCOUNT_END_TIME)) {
        foreach ($items as $key => $val) {
            if (PRICE_TABLE[$key]['type'] === 'bento') {
                $discount += (PRICE_TABLE[$key]['price'] / 2) * $val;
            }
        }
    }

    return $discount;
}

function bill(array $items, string $time): int
{
    $total = 0;
    foreach ($items as $key => $val) {
        $total += PRICE_TABLE[$key]['price'] * $val;
    }

    $total -= discount($items, $time);
    (int)$total *= (1 + TAX);
    return $total;
}

/*
function display(int $total): void
{
    echo $total . PHP_EOL;
}
*/

function calc(string $time, array $inputs): int
{
    $items = regroupItems($inputs);
    $total = bill($items, $time);
    return $total;
}

echo calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]) . PHP_EOL;
