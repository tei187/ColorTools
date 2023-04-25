<?php

namespace tei187\ColorTools\Traits;

/**
 * Handles contrast math between swatches.
 */
trait Contrast {
    /**
     * Calculates color contrast based on current object's values and reference object's values.
     *
     * @param object $reference Reference measure object.
     * @param integer|null $roundTo If integer, will round the outcome contrast to specified precision. If NULL (default), leaves original value.
     * @param boolean $returnAsRatio If set to TRUE, returns as string "x:1". If FALSE (default), returns float.
     * @return float|string
     */
    public function getContrast(object $reference, ?int $roundTo = null, bool $returnAsRatio = false) {
        // SOURCE: toRGB & remove gamma companding
        $rgb1 = $this->toRGB();
        $rgb1_gamma_inv = [];
        foreach($rgb1->getValues() as $k => $v) {
            $rgb1_gamma_inv[$k] = $this->primaries->applyInverseCompanding($v);
        }
        $rgb1_xyY = $this->getPrimaries()->getPrimariesXYY();

        // REFERENCE: toRGB & remove gamma companding
        $rgb2 = $reference->toRGB();
        $rgb2_gamma_inv = [];
        foreach($rgb2->getValues() as $k => $v) {
            $rgb2_gamma_inv[$k] = $this->primaries->applyInverseCompanding($v);
        }
        $rgb2_xyY = $rgb2->getPrimaries()->getPrimariesXYY();

        $rgb1 = $rgb1_gamma_inv; unset($rgb1_gamma_inv);
        $rgb2 = $rgb2_gamma_inv; unset($rgb2_gamma_inv);

        // CALCULATE LUMINANCE:
        $L1 = ($rgb1['R'] * $rgb1_xyY['R']['2']) 
            + ($rgb1['G'] * $rgb1_xyY['G']['2']) 
            + ($rgb1['B'] * $rgb1_xyY['B']['2']);

        $L2 = ($rgb2['R'] * $rgb2_xyY['R']['2'])
            + ($rgb2['G'] * $rgb2_xyY['G']['2']) 
            + ($rgb2['B'] * $rgb2_xyY['B']['2']);

        $contrast = ($L1 + .05) / ($L2 + .05);

        if($roundTo !== null) {
            $contrast = round($contrast, $roundTo);
        }

        return $returnAsRatio
            ? strval($contrast . ":1")
            : floatval($contrast);
    }
    
}