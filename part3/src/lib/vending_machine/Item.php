<?php

namespace VendingMachine;

abstract class Item
{
    private int $maxStockNumber = 50;
    private int $stockNumber = 0;
    abstract function getPrice();
    abstract function getCupNumber();

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function depositItem(int $stock)
    {
        $this->stockNumber += $stock;
        if ($this->stockNumber > $this->maxStockNumber) {
            $this->stockNumber = $this->maxStockNumber;
        }
    }

    public function getItemStockNumber(): int
    {
        return $this->stockNumber;
    }

    public function setMaxStockNumber(int $stockNum)
    {
        $this->maxStockNumber = $stockNum;
    }

    public function getMaxStockNumber(): int
    {
        return $this->maxStockNumber;
    }
}
