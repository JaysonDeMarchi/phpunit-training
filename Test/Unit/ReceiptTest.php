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
        $output = $this->receipt->total($input);

        $this->assertEquals(
            15,
            $output,
            'When summing the total should equal 15'
        );
    }
}
