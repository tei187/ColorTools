<?php

namespace tei187\ColorTools\Traits\Companding;

use tei187\ColorTools\Conversion\Convert;

/**
 * Methods specific for L\* companding. Native for ECI RGB v2 color space.
 */
trait LCompanding {
    /**
     * Applies L\* companding.
     *
     * @param float|integer $value
     * @return float|integer
     */
    public function applyCompanding($value) {
        return 
            $value <= Convert::EPSILON
                ? ($value * Convert::KAPPA) / 100
                : (1.16 * pow($value, 1/3)) - 0.16;
    }

    /**
     * Applies inverse L\* companding.
     *
     * @param float|integer $value
     * @return float|integer
     */
    public function applyInverseCompanding($value) {
        return 
            $value <= 0.08
                ? ($value / Convert::KAPPA) * 100
                : pow(($value + .16) / 1.16, 3);
    }
}