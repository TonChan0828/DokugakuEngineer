<?php

/*
データ構造を決める
入力値を取得する
データを処理しやすい形に変換する
合計時間を算出する
チャネルごとの視聴分数と視聴回数を算出する
表示する
*/

const SPLIT_LENGTH = 2;

function getInput()
{
    $argument = array_slice($_SERVER['argv'], 1);
    return array_chunk($argument, SPLIT_LENGTH);
}

function groupChannelViewingPeriod(array $inputs): array
{
    $channelViewingPeriod = [];
    foreach ($inputs as $input) {
        $chan = $input[0];
        $min = $input[1];
        $mins = [$min];

        if (array_key_exists($chan, $channelViewingPeriod)) {
            $channelViewingPeriod[$chan] = array_merge($channelViewingPeriod[$chan], $mins);
        } else {
            $channelViewingPeriod[$chan] = $mins;
        }
        ksort($channelViewingPeriod);
    }
    return $channelViewingPeriod;
}

function calculateTotalHour(array $channelViewingPeriod): float
{
    $viewingTimes = [];
    foreach ($channelViewingPeriod as $period) {
        $viewingTimes = array_merge($viewingTimes, $period);
    }
    return round(array_sum($viewingTimes) / 60, 1);
}

function display(array $channelViewingPeriod): void
{
    $totalHours = calculateTotalHour($channelViewingPeriod);
    echo $totalHours . PHP_EOL;
    foreach ($channelViewingPeriod as $chan => $mins) {
        echo $chan . ' ' . array_sum($mins) . ' ' . count($mins) . PHP_EOL;
    }
}

$inputs = getInput();
$channelViewingPeriod = groupChannelViewingPeriod($inputs);
display($channelViewingPeriod);



//$views = [];
//$i = 1;
//
//$total = [];
//$sumViewingTime = 0;
//
//while ($argv[$i] !== NULL) {
//    $view = [
//        'channel' => $argv[$i],
//        'viewingTime' => $argv[$i + 1]
//    ];
//    $views[] = $view;
//    $i += 2;
//}
//
//foreach ($views as $view) {
//    if (array_search($view['channel'], array_column($total, 'channel')) === false) {
//        $total[] = [
//            'channel' => (int)($view['channel']),
//            'viewingTime' => (int)$view['viewingTime'],
//            'views' => 1
//        ];
//        $sumViewingTime += $view['viewingTime'];
//    } else {
//        $key = array_search($view['channel'], array_column($total, 'channel'));
//        $total[$key]['viewingTime'] += (int)$view['viewingTime'];
//        ++$total[$key]['views'];
//        $sumViewingTime += $view['viewingTime'];
//    }
//}
//
//ksort($total);
//
//$sumViewingTime = round((float)($sumViewingTime / 60), 1);
//echo $sumViewingTime . PHP_EOL;
//foreach ($total as $channel) {
//    echo $channel['channel'] . ' ' .  $channel['viewingTime'] . ' ' . $channel['views'] . PHP_EOL;
//}
