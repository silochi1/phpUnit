<?php

namespace TDD;

use \BadMethodCallException;
class Receipt {
    /**
     * Returns the sum of items in an array
     * - Also applies coupon discount; if available
     * @return double|int
     */
    public function getSubTotal(array $items = [], $coupon = null) {
        $sum = array_sum($items);

        if ($coupon > 1.00) {
            throw new BadMethodCallException('The coupon cannot be greater than 1.00.');
        }

        // If a coupon exists, apply it to the sum...
        if(!is_null($coupon)) {
            return $sum - ($sum * $coupon);
        }
        return $sum;
    }

    /**
     * Returns the fee for taxes on the purchase...
     * @param $amount
     * @param $tax
     * @return float|int
     */
    public function getTax($amount, $tax) {
        return ($amount * $tax);
    }


    /**
     * Returns the total after taxes are applied...
     * @param $items
     * @param $tax
     * @param $coupon
     * @return float|int
     */
    public function postTaxTotal($items = [], $tax, $coupon) {
        $subtotal = $this->getSubTotal($items, $coupon);
        return $subtotal + $this->getTax($subtotal, $tax);
    }

    /**
     * Round the input to the nearest hundredth
     * @param $input float
     * @return float
     */
    public function currencyAmt($input)
    {
        // Round to the nearest hundredth...
        return round($input, 2);
    }



}