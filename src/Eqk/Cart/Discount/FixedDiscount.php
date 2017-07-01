<?php

namespace Eqk\Cart\Discount;


class FixedDiscount implements Discount
{
    public $discount;

    public function __construct($discount)
    {
        $this->discount = $discount;
    }

    public function ApplyDiscount(float $pre_total): float
    {
        if ($this->discount > $pre_total){
            return 0;
        }

        return $pre_total - $this->discount;
    }


}
