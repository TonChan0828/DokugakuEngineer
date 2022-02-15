<?php

namespace Poker;

interface PokerRule
{
    public function getHand(array $cards): string;
}
