<?php 

namespace TDD\Test;

// Require the autoload.php file rom the vendor directory
// - This will allow us to use the PHPUnit Framework
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Import PHPUnit's TestCase Class
use PHPUnit\Framework\TestCase;
use TDD\Receipt; // Namespace of Code to test


class ReceiptTest extends TestCase {

    public function setUp() {
        // Create an isolated object to test
        $this->Receipt = new Receipt();
    }

    public function tearDown() {
        // Delete/Unset object so that nothing carries over between tests
        // - i.e. Clearing cache
        unset($this->Receipt);
    }

    public function testGetTotal() {
        $input = [0,2,5,8];
        $output = $this->Receipt->getTotal($input); // Execute getTotal() method from Receipt class

        // Assertion for testing | Read more on phpunit documentaiton
        $this->assertEquals(
            15, // Expected value
            $output, // Actual Value
            'When summing, the total should equal 15' // Message to show if error received
        );
    }

    public function testGetTax() {
        $inputAmount = 10.00;
        $taxInput   = 0.10; // Percentage to be taxed

        $output = $this->Receipt->getTax($inputAmount, $taxInput);

        $this->assertEquals(
            1.00, // Expected value
            $output, // Actual Value
            'The tax calculation should equal 1.00' // Error Message
        );
    }
}