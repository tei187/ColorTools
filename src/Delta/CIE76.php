<?php

namespace tei187\ColorTools\Delta;

class CIE76 {
    /**
     * Calculates dE using CIE76 algorithm based on two L\*a\*b measures.
     * 
     * @link https://en.wikipedia.org/wiki/Color_difference#CIE76
     *
     * @param array $data Array holding two arrays with keys `0` and `1` (reference and sample), each holding three measure values for L, a, b respectively.
     * @return float
     */
    public static function calculateDelta(array $data) {
        list($L1, $a1, $b1) = $data[0];
        list($L2, $a2, $b2) = $data[1];
        return round( sqrt( pow(($L2 - $L1), 2) + pow(($a2 - $a1), 2) + pow(($b2 - $b1), 2) ) , 2);
    }
}
