<?php

namespace TDD;

class Receipt {
    /**
     * Returns the sum or items in an array
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
     * Returns the total tax calculation
     * @param $amount
     * @param $tax
     * @return float|int
     */
    public function getTax($amount, $tax) {
        return ($amount * $tax);
    }


}