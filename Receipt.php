<?php

namespace SomethingDigital\UnitTestTraining;

class Receipt
{
    public function total(array $items = []): int
    {
        return array_sum($items);
    }

    public function tax(float $amount, float $taxPercent): float
    {
        return ($amount * $taxPercent);
    }
}
