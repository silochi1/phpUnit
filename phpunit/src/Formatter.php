<?php

namespace TDD;

class Formatter
{
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