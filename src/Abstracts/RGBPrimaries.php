<?php

namespace tei187\ColorTools\Abstracts;

use tei187\ColorTools\Interfaces\RGBPrimaries as RGBPrimariesInterface;
use tei187\ColorTools\Illuminants\Illuminant;

/**
 * Abstract class for RGB primaries.
 */
abstract class RGBPrimaries implements RGBPrimariesInterface {
    /**
     * xyY array of RGB primaries.
     *
     * @return float[]
     */
    const XYY = self::XYY;

    /**
     * Name of the RGB primaries set.
     *
     * @return string|null The name of the RGB primaries, or null if not available.
     */
    const NAME = self::NAME;
    
    /**
     * Standard illuminant name used for the RGB primaries set.
     *
     * @return string|null The standard illuminant name, or null if not defined.
     */
    const ILLUMINANT = self::ILLUMINANT;

    /**
     * Gamma value for the RGB primaries set.
     *
     * @return int|float The gamma value.
     */
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
     * Returns the illuminant associated with the RGB primaries.
     *
     * @todo include custom illuminants dictionaries
     * 
     * @return Illuminant|null The illuminant, or null if not available.
     */
    public function getIlluminant(): ?Illuminant
    {
        return Illuminant::from(static::ILLUMINANT, 2);
    }

    /**
     * Returns gamma value.
     *
     * @return int|float|string
     */
    public function getGamma() { return static::GAMMA; }

    /**
     * Returns tristimulus of the illuminant.
     *
     * @return array
     */
    public function getIlluminantTristimulus(): array {
        return ($this->getIlluminant())->getTristimulus();
    }

}