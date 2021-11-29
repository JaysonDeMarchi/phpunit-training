<?php

namespace SomethingDigital\UnitTestTraining;

class Receipt
{
    public function total(array $items = [], ?float $coupon = null): int
    {
        $total = array_sum($items);
        if ($coupon) {
            $total *= 1 - $coupon;
        }
        return $total;
    }

    public function tax(float $amount, float $taxPercent): float
    {
        return ($amount * $taxPercent);
    }
}
