<?php

namespace VendingMachine;

require_once('Item.php');

class Snack extends Item
{
    private const PRICE = [
        'potato chips'  => 150,
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
        return 0;
    }
}
