<?php

namespace Eqk\Cart\Discount;


class PercentDiscount implements Discount
{
    public $percents;

    function __construct($percents)
    {
        $this->percents = $percents;
    }

    public function ApplyDiscount(float $pre_total): float
    {
        return $pre_total * $this->percents / 100;
    }
}
