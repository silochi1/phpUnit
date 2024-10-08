<?php 

namespace TDD\Test;

// Require the autoload.php file rom the vendor directory
// - This will allow us to use the PHPUnit Framework
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Import PHPUnit's TestCase Core Class
use PHPUnit\Framework\TestCase;
use TDD\Receipt; // Namespace of Code to test


class ReceiptTest extends TestCase {

    public function setUp() {
        // Create an isolated object to test

        $this->Formatter = $this->getMockBuilder('TDD\Formatter')
            ->setMethods(['currencyAmt'])
            ->getMock();

        // Expected to be called any number of times...
        $this->Formatter->expects($this->any())
            ->method('currencyAmt')
            ->with($this->anything())
            ->will($this->returnArgument(0));

        $this->Receipt = new Receipt($this->Formatter);
    }

    public function tearDown() {
        // Delete/Unset object so that nothing carries over between tests
        // - i.e. Clearing cache
        unset($this->Receipt);
    }


    /**
     * @dataProvider provideSubTotal
     * @return void
     */
    public function testGetSubTotal($items, $expected) {
        $input = [0,2,5,8];
        $coupon = null;
        $output = $this->Receipt->getSubTotal($items, $coupon); // Execute getTotal() method from Receipt class

        // Assertion for testing | Read more on phpunit documentaiton
        $this->assertEquals(
            $expected, // Expected value
            $output, // Actual Value
            "When summing, the total should equal $expected" // Message to show if error received
        );
    }

    public function provideSubTotal()
    {
        return [
            // (i.e.) [[inputs], outputValue]
            'ints totaling 16' => [[1, 2, 5, 8], 16], // Test Data 1.
            [[-1, 2, 5, 8], 14], // Test Data 2.
            [[1, 2, 8], 11] // Test Data 3.
        ];
    }

    /**
     * Test that the correct sum is calculated from the total & coupon
     * @return void
     */
    public function testGetSubTotalAndCoupon() {
        $input = [0,2,5,8];
        $coupon = 0.20;
        $output = $this->Receipt->getSubTotal($input, $coupon); // Execute getTotal() method from Receipt class

        // Assertion for testing | Read more on phpunit documentaiton
        $this->assertEquals(
            12, // Expected value
            $output, // Actual Value
            'When summing, the total should equal 12' // Message to show if error received
        );
    }

    /**
     * Test to see that the correct exception is thrown when an invalid coupon is provided
     * @return void
     */
    public function testGetSubTotalAndCouponException() {
        $input = [0,2,5,8];
        $coupon = 1.20;

        // Assertion that an exception was thrown...
        $this->expectException('BadMethodCallException');
        $this->Receipt->getSubTotal($input, $coupon);
    }

    public function testGetTax() {
        $inputAmount = 10.00;

        // Dynamically add the property 'tax' to the instance of the 'Receipt' class
        // - No need to define explicitly in the class...
        $this->Receipt->tax   = 0.10; // Percentage to be taxed

        $output = $this->Receipt->getTax($inputAmount);

        $this->assertEquals(
            1.00, // Expected value
            $output, // Actual Value
            'The tax calculation should equal 1.00' // Error Message
        );
    }

    // Mock Example
    public function testPostTaxTotal() {
        // Dummy data...
        $items = [1,2,5,8];
        $taxAmount = 0.20;
        $coupon = null;


        // Build the Mock:
        // - Specify class and methods to use...
        $receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['getTax', 'getSubTotal'])
            ->setConstructorArgs([$this->Formatter])
            ->getMock();

        // We expect the getTotal() method to return a value of 10.00...
        // - We only expect to call the getTotal() method once
        $receipt->expects($this->once())
            ->method('getSubTotal')
            ->with($items, $coupon) // Specify params...
            ->will($this->returnValue(10.00));

        // We expect the getTax() method to return a value of 1.00...
        // - We only expect to call the getTax() method once
        $receipt->expects($this->once())
            ->method('getTax')
            ->with(10.00) // Specify params...
            ->will($this->returnValue('1.00'));

        // Value assertion...
        $result = $receipt->postTaxTotal([1,2,5,8], null); // params: Items[], taxTotal, Coupon
        $this->assertEquals(11.00, $result);
    }
}