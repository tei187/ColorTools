<?php

namespace tei187\ColorTools\Traits\Companding;

/**
 * Methods specific for linear gamma companding.
 */
trait GammaCompanding {
    /**
     * Applies gamma companding.
     *
     * @param float|integer $value
     * @param float|integer $gamma
     * @return float|integer
     */
    public function applyCompanding($value, $gamma) {
        return pow($value, 1/$gamma);
    }

    /**
     * Applies inverse gamma companding.
     *
     * @param float|integer $value
     * @param float|integer $gamma
     * @return float|integer
     */
    public function applyInverseCompanding($value, $gamma) {
        return pow($value, $gamma);
    }
}