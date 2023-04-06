<?php

namespace tei187\ColorTools\Traits\Companding;

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
}