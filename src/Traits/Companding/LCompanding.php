<?php

namespace tei187\ColorTools\Traits\Companding;

use tei187\ColorTools\Conversion\Convert;

trait LCompanding {
    /**
     * Applies L* companding.
     *
     * @param float|integer $value
     * @return float|integer
     */
    public function applyCompanding($value) {
        return 
            $value <= Convert::EPSILON
                ? Convert::EPSILON_x_KAPPA / 100
                : (1.16 * pow($value, 1/3)) - 0.16;
    }
}