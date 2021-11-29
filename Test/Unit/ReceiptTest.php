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

    /**
     * @dataProvider provideTotal
     */
    public function testTotal($items, $expected): void
    {
        $couponPercent = null;
        $output = $this->receipt->total($items, $couponPercent);

        $this->assertEquals(
            $expected,
            $output,
            "When summing the total should equal ${expected}"
        );
    }

    public function provideTotal(): array
    {
        return [
            [
                [1,2,5,8],
                16,
            ],
            [
                [-1,2,5,8],
                14,
            ],
            [
                [1,2,8],
                11,
            ],
        ];
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

    public function testPostTaxTotal(): void
    {
        $items = [1,2,5,8];
        $taxPercent = 0.20;
        $coupon = null;
        $receipt = $this->getMockBuilder(
            Receipt::class
        )->setMethods([
            'tax',
            'total',
        ])->getMock();

        $receipt->expects(
            $this->once()
        )->method(
            'total'
        )->with(
            $items,
            $coupon
        )->will($this->returnValue(10.00));

        $receipt->expects(
            $this->once()
        )->method(
            'tax'
        )->with(
            10.00,
            $taxPercent
        )->will($this->returnValue(1.00));

        $result = $receipt->testPostTaxTotal($items, $taxPercent, $coupon);

        $this->assertEquals(
            11.00,
            $result
        );
    }
}
