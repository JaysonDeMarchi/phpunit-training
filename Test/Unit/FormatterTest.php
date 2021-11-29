<?php

namespace SomethingDigital\UnitTestTraining\Test\Unit;

use PHPUnit\Framework\TestCase;
use SomethingDigital\UnitTestTraining\Formatter;

class FormatterTest extends TestCase
{
    protected $formatter;

    public function setUp(): void
    {
        $this->formatter = new Formatter();
    }

    public function tearDown(): void
    {
        unset($this->formatter);
    }

    /**
     * @dataProvider provideCurrencyAmount
     */
    public function testCurrencyAmount($input, float $expected, string $message): void
    {
        $this->assertSame(
            $expected,
            $this->formatter->currencyAmount($input),
            $message
        );
    }

    public function provideCurrencyAmount(): array
    {
        return [
            [
                1,
                1.00,
                '1 should be transformed into 1.00',
            ],
            [
                1.1,
                1.10,
                '1.1 should be transformed into 1.10',
            ],
            [
                1.11,
                1.11,
                '1.11 should be transformed into 1.11',
            ],
            [
                1.111,
                1.11,
                '1.111 should be transformed into 1.11',
            ],
        ];
    }
}
