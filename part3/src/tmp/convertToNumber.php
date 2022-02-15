<?php

function convertToNumber(string ...$array): array
{
    $nums = [];
    $num = function ($array) use ($nums) {
        foreach ($array as $card) {
            $nums[] = substr($card, 1);
        }
        return $nums;
    };
    return $num($array);
}
