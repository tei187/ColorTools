<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;

use tei187\ColorTools\Interfaces\Primaries as PrimariesInterface;

abstract class PrimariesAbstract implements PrimariesInterface {

    const XYY = self::XYY;
    const NAME = self::NAME;
    const ILLUMINANT = self::ILLUMINANT;
    const GAMMA = self::GAMMA;

    /**
     * Returns xyY array of RGB primaries.
     *
     * @return array
     */
    public function getPrimariesXYY() : array { return static::XYY; }
    /**
     * Returns formatted name of primaries used.
     *
     * @return string|null
     */
    public function getPrimariesName() : ?string { return static::NAME; }
    /**
     * Returns standard illuminant for specified primaries used.
     *
     * @return string|null
     */
    public function getIlluminantName() : ?string { return static::ILLUMINANT; }
    /**
     * Returns tristimulus for illuminant for specified primaries used.
     * If specified standard illuminant was not found, returns D65.
     *
     * @return array
     */
    public function getIlluminantTristimulus() : array {
        $data = constant("\\tei187\\ColorTools\\StandardIlluminants\\Tristimulus2::".strtoupper(static::ILLUMINANT));
        if($data === null) {
            return \tei187\ColorTools\StandardIlluminants\Tristimulus2::D65;
        }
        return $data;
    }
    /**
     * Returns gamma value.
     *
     * @return int|float|string
     */
    public function getGamma() { return static::GAMMA; }

}