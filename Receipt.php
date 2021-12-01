<?php

namespace SomethingDigital\UnitTestTraining;

use SomethingDigital\UnitTestTraining\Api\FormatterInterface;

use \BadMethodCallException;

class Receipt
{
    protected $taxPercent;
    protected $formatter;

    public function __construct(
        FormatterInterface $formatter,
        float $taxPercent = 0.10
    ) {
        $this->formatter = $formatter;
        $this->taxPercent = $taxPercent;
    }

    public function getSubtotal(array $items = [], ?float $coupon = null): float
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
        return $this->formatter->currencyAmount($amount * $this->taxPercent);
    }

    public function postTaxTotal(array $items, ?float $coupon = null): float
    {
        $subtotal = $this->getSubtotal($items, $coupon);
        return $subtotal + $this->tax($subtotal, $this->taxPercent);
    }
}
