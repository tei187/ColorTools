<?php

namespace tei187\ColorTools\Traits\Companding;

/**
 * Methods specific for linear gamma companding.
 */
trait GammaCompanding {
    /**
     * Applies gamma companding to the given value.
     *
     * @param float|integer $value The value to apply gamma companding to.
     * @param float|integer $gamma The gamma value to use for companding.
     * @return float|integer The value after gamma companding is applied.
     */
    public function applyCompanding($value, $gamma)
    {
        return pow($value, 1 / $gamma);
    }

    /**
     * Applies inverse gamma companding.
     *
     * @param float|integer $value The value to apply inverse gamma companding to.
     * @param float|integer $gamma The gamma value to use for inverse companding.
     * @return float|integer The value after inverse gamma companding is applied.
     */
    public function applyInverseCompanding($value, $gamma)
    {
        return pow($value, $gamma);
    }
}