<?php

namespace VendingMachine;

require_once('Item.php');

class Drink extends Item
{
    private const PRICE = [
        'cola'  => 150,
        'cider' => 100,
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
