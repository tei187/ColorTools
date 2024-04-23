<?php

namespace tei187\ColorTools\Interfaces;

use tei187\ColorTools\Illuminants\Illuminant;

/**
 * Interface for RGB primaries methods.
 */
interface RGBPrimaries {
    /**
     * Gets the CIE xyY coordinates of the RGB primaries.
     *
     * @return array An array containing the xyY coordinates of the RGB primaries.
     */
    public function getPrimariesXYY(): array;

    /**
     * Gets the name of the RGB primaries.
     *
     * @return ?string The name of the RGB primaries, or null if not available.
     */
    public function getPrimariesName(): ?string;

    /**
     * Returns the illuminant associated with the RGB primaries.
     *
     * @return Illuminant|null The illuminant, or null if not available.
     */
    public function getIlluminant(): ?Illuminant;

    /**
     * Gets the gamma value.
     *
     * @return float The gamma value.
     */
    public function getGamma();
}