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
        $this->receipt->taxPercent = 0.10;
    }

    public function tearDown(): void
    {
        unset($this->receipt);
    }

    /**
     * @dataProvider provideGetSubtotal
     */
    public function testGetSubtotal($items, $expected): void
    {
        $couponPercent = null;
        $output = $this->receipt->getSubTotal($items, $couponPercent);

        $this->assertEquals(
            $expected,
            $output,
            "When summing the total should equal ${expected}"
        );
    }

    public function provideGetSubtotal(): array
    {
        return [
            'ints totaling 16' => [
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

    public function testGetSubtotalAndCoupon(): void
    {
        $input = [0,2,5,8];
        $couponPercent = 0.20;
        $output = $this->receipt->getSubTotal($input, $couponPercent);

        $this->assertEquals(
            12,
            $output,
            'When summing the total should equal 12'
        );
    }

    public function testGetSubtotalException(): void
    {
        $input = [0,2,5,8];
        $couponPercent = 1.20;
        $this->expectException('BadMethodCallException');
        $this->receipt->getSubTotal($input, $couponPercent);
    }

    public function testTax(): void
    {
        $input = [
            'amount' => 10.00,
        ];
        $output = $this->receipt->tax($input['amount']);

        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }

    public function testPostTaxTotal(): void
    {
        $items = [1,2,5,8];
        $coupon = null;
        $receipt = $this->getMockBuilder(
            Receipt::class
        )->setMethods([
            'tax',
            'getSubtotal',
        ])->getMock();

        $receipt->expects(
            $this->once()
        )->method(
            'getSubtotal'
        )->with(
            $items,
            $coupon
        )->will($this->returnValue(10.00));

        $receipt->expects(
            $this->once()
        )->method(
            'tax'
        )->with(
            10.00
        )->will($this->returnValue(1.00));

        $result = $receipt->testPostTaxTotal($items, $coupon);

        $this->assertEquals(
            11.00,
            $result
        );
    }

    /**
     * @dataProvider provideCurrencyAmount
     */
    public function testCurrencyAmount($input, float $expected, string $message): void
    {
        $this->assertSame(
            $expected,
            $this->receipt->currencyAmount($input),
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
