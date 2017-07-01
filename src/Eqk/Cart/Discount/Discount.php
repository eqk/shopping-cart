<?php

namespace Eqk\Cart\Discount;


interface Discount
{
    public function ApplyDiscount(float $pre_total): float;
}
