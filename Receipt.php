<?php

namespace SomethingDigital\UnitTestTraining;

class Receipt
{
    public function total(array $items = []): int
    {
        return array_sum($items);
    }
}
