<?php

function checkHIT(string $question, string $answer): int
{
    $hit = 0;
    for ($i = 0; $i < 4; $i++) {
        if ($question[$i] === $answer[$i]) {
            $hit++;
        }
    }
    return $hit;
}

function checkBLOW(string $question, string $answer): int
{
    $blow = 0;
    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 4; $j++) {
            if ($question[$i] === $answer[$j]) {
                $blow++;
            }
        }
    }
    return $blow;
}


function judge(int $question, int $answer): array
{
    $question = strval($question);
    $answer  = strval($answer);
    $hit  = checkHIT($question, $answer);
    $blow = checkBLOW($question, $answer);
    $blow -= $hit;
    return array($hit, $blow);
}

judge(5678, 5678);
