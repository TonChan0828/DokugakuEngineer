<?php

namespace VendingMachine;

require_once(__DIR__ . '/Drink.php');
require_once(__DIR__ . '/CupDrink.php');
require_once(__DIR__ . '/Snack.php');

class VendingMachine
{
    private int $depositedCoin = 0;
    private int $totalCup = 0;
    private const MAX_CUP = 100;

    public function __construct()
    {
    }

    public function depositCoin(int $coinAmount)
    {

        if ($coinAmount === 100) {
            $this->depositedCoin += $coinAmount;
        }

        return $this->depositedCoin;
    }

    public function pressButton(Item $drink): string
    {
        $cupNumber = $drink->getCupNumber();
        if ($this->depositedCoin >= $drink->getPrice() && $this->totalCup >= $cupNumber && $drink->getItemStockNumber() > 0) {
            $this->depositedCoin -= $drink->getPrice();
            $this->totalCup -= $cupNumber;
            return $drink->getName();
        }

        return '';
    }

    public function addCup(int $cup): int
    {
        $this->totalCup += $cup;
        if ($this->totalCup > VendingMachine::MAX_CUP) {
            $this->totalCup = 100;
        }
        return $this->totalCup;
    }

    public function receiveChange(): int
    {
        $change = $this->depositedCoin;
        $this->depositedCoin = 0;
        return $change;
    }

    public function depositItem(Item $item, int $itemNum): int
    {
        $item->depositItem($itemNum);
        return $item->getItemStockNumber();
    }
}
