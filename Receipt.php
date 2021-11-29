<?php

namespace SomethingDigital\UnitTestTraining;

use \BadMethodCallException;

class Receipt
{
    public function currencyAmount($input): float
    {
        return round($input, 2);
    }

    public function getSubtotal(array $items = [], ?float $coupon = null): int
    {
        if ($coupon > 1.00) {
            throw new BadMethodCallException('Coupon must be <= 1.00');
        }
        $total = array_sum($items);
        if ($coupon) {
            $total *= 1 - $coupon;
        }
        return $total;
    }

    public function tax(float $amount): float
    {
        return ($amount * $this->taxPercent);
    }

    public function testPostTaxTotal(array $items, ?float $coupon = null): float
    {
        $subtotal = $this->getSubtotal($items, $coupon);
        return $subtotal + $this->tax($subtotal, $taxPercent);
    }
}
