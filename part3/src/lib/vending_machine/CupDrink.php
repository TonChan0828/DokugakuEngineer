<?php

namespace VendingMachine;

use VendingMachine\Item;

require_once('Item.php');

class CupDrink extends Item
{
    private const PRICE = [
        'hot cup coffee' => 100,
        'ice cup coffee' => 100,
    ];

    public function __construct(private string $name)
    {
        parent::__construct($name);
    }

    public function getPrice()
    {
        return self::PRICE[$this->name];
    }

    public function getCupNumber()
    {
        return 1;
    }
}
