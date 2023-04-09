<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\RGBPrimaries\sRGB;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Measures\MeasureAbstract;

abstract class RGBMeasureAbstract extends MeasureAbstract {
    use Illuminants,
        PrimariesLoader;

    protected $values = [
        'R' => 0,
        'G' => 0,
        'B' => 0
    ];
    protected $primaries;

    /**
     * @param array $values Array with RGB values in [0-255] range.
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
        $this->setIlluminant($this->primaries::ILLUMINANT, 2);
        $this->illuminantT = $this->primaries->getIlluminantTristimulus();
    }

    /**
     * Converts from RGB to XYZ values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return XYZ
     */
    abstract public function toXYZ(): XYZ;
    /**
     * Converts from RGB to xyY values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return xyY
     */
    abstract public function toxyY(): xyY;
    /**
     * Converts from RGB to L\*a\*b values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return Lab
     */
    abstract public function toLab(): Lab;
    /**
     * Converts from RGB to L\*C\*h values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return LCh
     */
    abstract public function toLCh(): LCh;
    /**
     * Converts from RGB to LChUV values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return LCh_uv
     */
    abstract public function toLCh_uv(): LCh_uv;
    /**
     * Converts from RGB to Luv values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return Luv
     */
    abstract public function toLuv(): Luv;
    abstract public function toRGB($primaries = 'sRGB'): RGB;
}