<?php

namespace SomethingDigital\UnitTestTraining\Api;

interface FormatterInterface
{
    public function currencyAmount($input): float;
}
