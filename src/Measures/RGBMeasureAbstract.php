<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\RGBPrimaries\Standard\sRGB;
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

    /**
     * Returns RGB values in hex form.
     *
     * @param boolean $asString Boolean switch. If true, returns a string in '#RRGGBB' formatting. If false, returns an array with RGB keys.
     * @return array|string
     */
    public function getValuesHex(bool $asString = false) {
        list($R, $G, $B) = array_values($this->getValues());
        if(!$asString) {
            return [
                'R' => dechex($R),
                'G' => dechex($G),
                'B' => dechex($B) 
            ];
        }
        return "#".dechex($R).dechex($G).dechex($B);
    }

    /**
     * Returns RGB values in float form, from 0 to 1.
     *
     * @return array
     */
    public function getValuesFloat() : array {
        list($R, $G, $B) = array_values($this->getValues());
        return [
            'R' => $R / 255,
            'G' => $G / 255,
            'B' => $B / 255
        ];
    }
}