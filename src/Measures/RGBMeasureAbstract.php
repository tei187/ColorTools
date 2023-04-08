<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\RGBPrimaries\sRGB;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Measures\MeasureAbstract;

abstract class RGBMeasureAbstract extends MeasureAbstract {
    use Illuminants,
        ReturnsObjects,
        PrimariesLoader;

    protected $values = [
        'R' => 0,
        'G' => 0,
        'B' => 0
    ];
    protected $primaries;

    /**
     * Undocumented function
     *
     * @param array $values
     * @param object $primaries RGB primaries object of tei187\ColorTools\Conversion\RGBPrimaries namespace.
     */
    public function __construct(array $values, $primaries) {
        $this->_setValuesKeys('RGB');
        $this->setValues($values);
        $assessedPrimaries = $this->loadPrimaries($primaries);
        $this->primaries =
            $assessedPrimaries === false
            ? new sRGB
            : $assessedPrimaries;
    }
}