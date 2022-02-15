<?php

/*
データ構造を決める
入力値を取得する
処理しやすい形に変換
視聴時間の合計を計算する
表示する
*/

const SPLIT_LENGTH = 2;

function Inputs(array $argv): array
{
    $inputs = array_slice($argv, 1);
    return array_chunk($inputs, SPLIT_LENGTH);
}

//function Input(): array
//{
//    $inputs = array_slice($_SERVER['argv'], 1);
//    return array_chunk($inputs, SPLIT_LENGTH);
//}

function groupChannelViewingPeriods(array $inputs): array
{
    $viewingChannelPeriods = [];
    foreach ($inputs as $input) {
        $chan = $input[0];
        $min  = $input[1];
        $mins = [$min];
        if (array_key_exists($chan, $viewingChannelPeriods)) {
            $viewingChannelPeriods[$chan] = array_merge($viewingChannelPeriods[$chan], $mins);
        } else {
            $viewingChannelPeriods[$chan] = $mins;
        }
    }
    return $viewingChannelPeriods;
}

function calculateTotalHours(array $viewingChannelPeriods): float
{
    $viewingTimes = [];
    foreach ($viewingChannelPeriods as $channel) {
        $viewingTimes = array_merge($viewingTimes, $channel);
    }
    return round((array_sum($viewingTimes) / 60), 1);
}

function displays(array $viewingChannelPeriods): void
{
    $totalHours = calculateTotalHours($viewingChannelPeriods);
    echo $totalHours . PHP_EOL;
    foreach ($viewingChannelPeriods as $chan => $mins) {
        echo $chan . ' ' . array_sum($mins) . ' ' . count($mins) . PHP_EOL;
    }
}



$inputs = Inputs($_SERVER['argv']);
$viewingChannelPeriods = groupChannelViewingPeriods($inputs);
displays($viewingChannelPeriods);
