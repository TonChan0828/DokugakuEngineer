<?php

trait TaxCalculator
{
    private int $price;

    public function taxedPrice()
    {
        return $this->price;
    }
}

trait AmericanTaxCalculator
{
    private int $price;
    public function taxedPrice()
    {
        return $this->price;
    }
}
