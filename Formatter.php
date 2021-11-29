<?php

namespace SomethingDigital\UnitTestTraining;

use SomethingDigital\UnitTestTraining\Api\FormatterInterface;

class Formatter implements FormatterInterface
{
    public function currencyAmount($input): float
    {
        return round($input, 2);
    }
}
