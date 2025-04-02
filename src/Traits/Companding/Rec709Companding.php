<?php

namespace tei187\ColorTools\Traits\Companding;

/**
 * Methods specific for sRGB companding. Native for sRRGB color space.
 */
trait Rec709Companding {
    /**
     * Applies Rec.709 companding to the given value.
     *
     * If the value is less than or equal to 0.0031308, it is scaled using the linear Rec.709 formula.
     * Otherwise, it is transformed using the nonlinear Rec.709 formula.
     *
     * @param float|integer $value The value to apply Rec.709 companding to.
     * @return float|integer The companded value.
     */
    public function applyCompanding($value)
    {
        return
            $value <= .0018
            ? 4.5 * $value
            : (1.099 * pow($value, 1 / 2.2) - 0.099);
    }

    /**
     * Applies inverse Rec.709 companding.
     *
     * If the value is less than or equal to 0.04045, it is scaled using the linear Rec.709 formula.
     * Otherwise, it is transformed using the nonlinear Rec.709 formula.
     *
     * @param float|integer $value The value to apply inverse Rec.709 companding to.
     * @return float|integer The decompanded value.
     */
    public function applyInverseCompanding($value)
    {
        return
            $value <= .081
            ? $value / 4.5
            : pow((($value + .099) / 1.099), 2.2);
    }
}