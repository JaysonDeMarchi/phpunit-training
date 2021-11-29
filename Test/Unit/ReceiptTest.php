<?php

namespace SomethingDigital\UnitTestTraining\Test\Unit;

use SomethingDigital\UnitTestTraining\Receipt;
use PHPUnit\Framework\TestCase;

class ReceiptTest extends TestCase
{
    protected $receipt;

    public function setUp(): void
    {
        $this->receipt = new Receipt();
    }

    public function tearDown(): void
    {
        unset($this->receipt);
    }

    public function testTotal(): void
    {
        $input = [0,2,5,8];
        $couponPercent = null;
        $output = $this->receipt->total($input, $couponPercent);

        $this->assertEquals(
            15,
            $output,
            'When summing the total should equal 15'
        );
    }

    public function testTotalAndCoupon(): void
    {
        $input = [0,2,5,8];
        $couponPercent = 0.20;
        $output = $this->receipt->total($input, $couponPercent);

        $this->assertEquals(
            12,
            $output,
            'When summing the total should equal 12'
        );
    }

    public function testTax(): void
    {
        $input = [
            'amount' => 10.00,
            'taxPercent' => 0.10,
        ];
        $output = $this->receipt->tax($input['amount'], $input['taxPercent']);

        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }
}
