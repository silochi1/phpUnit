<?php

namespace TDD\Test;

// Require the autoload.php file rom the vendor directory
// - This will allow us to use the PHPUnit Framework
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Formatter;

class FormatterTest extends TestCase
{
    public function setUp() {
        // Create an isolated object to test
        $this->Formatter = new Formatter();
    }

    public function tearDown() {
        // Delete/Unset object so that nothing carries over between tests
        // - i.e. Clearing cache
        unset($this->Formatter);
    }

    /**
     * @dataProvider provideCurrencyAmount
     * @param $input
     * @param $expected
     * @param $msg
     * @return void
     */
    public function testCurrencyAmount($input, $expected, $msg)
    {
        $this->assertSame(
            $expected,
            $this->Formatter->currencyAmt($input),
            $msg
        );
    }

    /**
     * Data provider method for the testCurrencyAmount() method...
     * @return array[]
     */
    public function provideCurrencyAmount()
    {
        return [
            [1, 1.00, '1 should be transformed into 1.00'],
            [1.1, 1.10, '1.1 should be transformed into 1.10'],
            [1.11, 1.11, '1.11 should remain as 1.11'],
            [1.111, 1.11, '1.111 should be transformed into 1.11'],
        ];
    }

}
