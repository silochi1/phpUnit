<?php

namespace TDD;

class Receipt {
    public function getTotal(array $items = []) {
        return array_sum($items);
    }

    public function getTax($amount, $tax) {
        return ($amount * $tax);
    }
}