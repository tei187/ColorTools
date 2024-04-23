<?php

namespace tei187\ColorTools\Traits\Companding;

/**
 * Methods specific for sRGB companding. Native for sRRGB color space.
 */
trait sRGBCompanding {
    /**
     * Applies sRGB companding to the given value.
     *
     * If the value is less than or equal to 0.0031308, it is scaled using the linear sRGB formula.
     * Otherwise, it is transformed using the nonlinear sRGB formula.
     *
     * @param float|integer $value The value to apply sRGB companding to.
     * @return float|integer The companded value.
     */
    public function applyCompanding($value)
    {
        return
            $value <= .0031308
            ? 12.92 * $value
            : (1.055 * pow($value, 1 / 2.4) - 0.055);
    }

    /**
     * Applies inverse sRGB companding.
     *
     * If the value is less than or equal to 0.04045, it is scaled using the linear sRGB formula.
     * Otherwise, it is transformed using the nonlinear sRGB formula.
     *
     * @param float|integer $value The value to apply inverse sRGB companding to.
     * @return float|integer The decompanded value.
     */
    public function applyInverseCompanding($value)
    {
        return
            $value <= .04045
            ? $value / 12.92
            : pow((($value + .055) / 1.055), 2.4);
    }
}