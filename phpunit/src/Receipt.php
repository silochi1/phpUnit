<?php

namespace TDD;

class Receipt {
    /**
     * Returns the sum of items in an array
     * - Also applies coupon discount; if available
     * @return double|int
     */
    public function getTotal(array $items = [], $coupon = null) {
        $sum = array_sum($items);

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
        $subtotal = $this->getTotal($items, $coupon);
        return $subtotal + $this->getTax($subtotal, $tax);
    }


}