<?php

namespace tei187\ColorTools\Traits\Companding;

use tei187\ColorTools\Math\ModelConversion;

/**
 * Methods specific for L\* companding. Native for ECI RGB v2 color space.
 */
trait LCompanding {
    /**
     * Applies L\* companding to the provided value.
     *
     * If the value is less than or equal to the epsilon constant, the value is scaled by the kappa constant and divided by 100.
     * Otherwise, the value is transformed using the formula (1.16 * pow(value, 1/3)) - 0.16.
     *
     * @param float|integer $value The value to apply L* companding to.
     * @return float|integer The transformed value after applying L* companding.
     */
    public function applyCompanding($value)
    {
        return
            $value <= ModelConversion::EPSILON
            ? ($value * ModelConversion::KAPPA) / 100
            : (1.16 * pow($value, 1 / 3)) - 0.16;
    }

    /**
     * Applies inverse L\* companding.
     *
     * If the value is less than or equal to 0.08, the value is scaled by the kappa constant and divided by 100.
     * Otherwise, the value is transformed using the formula pow(($value + .16) / 1.16, 3).
     *
     * @param float|integer $value The value to apply inverse L* companding to.
     * @return float|integer The transformed value after applying inverse L* companding.
     */
    public function applyInverseCompanding($value)
    {
        return
            $value <= 0.08
            ? ($value / ModelConversion::KAPPA) * 100
            : pow(($value + .16) / 1.16, 3);
    }
}