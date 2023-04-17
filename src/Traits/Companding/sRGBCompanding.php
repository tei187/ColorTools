<?php

namespace tei187\ColorTools\Traits\Companding;

/**
 * Methods specific for sRGB companding. Native for sRRGB color space.
 */
trait sRGBCompanding {
    /**
     * Applies sRGB companding.
     *
     * @param float|integer $value
     * @return float|integer
     */
    public function applyCompanding($value) {
        return 
            $value <= .0031308
                ? 12.92 * $value
                : (1.055 * pow($value, 1/ 2.4) - 0.055);
    }

    /**
     * Applies inverse sRGB companding.
     *
     * @param float|integer $value
     * @return float|integer
     */
    public function applyInverseCompanding($value) {
        return 
            $value <= .04045
                ? $value / 12.92
                : pow((($value + .055) / 1.055), 2.4);
    }
}