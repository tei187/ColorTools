<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;

use tei187\ColorTools\Interfaces\Primaries as PrimariesInterface;
use tei187\ColorTools\Traits\Companding\GammaCompanding;
use tei187\ColorTools\StandardIlluminants\Dictionary as StandardIlluminantDictionary;

/**
 * Class for creation of custom sets of RGB primaries.
 */
class Custom implements PrimariesInterface {
    use GammaCompanding;
    private $xyy = [];
    private $name = null;
    private $illuminant = null;
    private $gamma = 2.2;

    /**
     * Custom primaries class constructor.
     *
     * @param array $xyy Array of arrays with xyY values for each channel.
     * @param string|null $name Custom name for primaries.
     * @param string|array $illuminant Name of standard illuminant or XYZ tristimulus values as array.
     * @param float $gamma Float gamma value. By default `2.2`.
     */
    public function __construct(array $xyy, ?string $name = null, $illuminant = null, float $gamma = 2.2) {
        $this->xyy = $xyy;
        $this->name = $name;
        $this->illuminant = 
            $illuminant === null || (is_string($illuminant) && strlen(trim($illuminant)) == 0)
                ? 'D65'
                : (
                    is_string($illuminant) 
                    ? (
                        StandardIlluminantDictionary::assessStandardIlluminant($illuminant) === false
                            ? 'D65'
                            : strtoupper(trim($illuminant))
                      )
                    : (
                        is_array($illuminant)
                            ? $illuminant
                            : null
                      )
                );
        $this->gamma = $gamma;
    }
    /**
     * Returns xyY array of RGB primaries.
     *
     * @return array
     */
    public function getPrimariesXYY() : array {
        return $this->xyy;
    }
    /**
     * Returns formatted name of primaries used.
     *
     * @return string|null
     */
    public function getPrimariesName() : ?string {
        return $this->name;
    }
    /**
     * Returns standard illuminant for specified primaries used.
     *
     * @return string|null
     */
    public function getIlluminantName() : ?string {
        return
            is_array($this->illuminant)
                ? null
                : $this->illuminant;
    }
    /**
     * Returns tristimulus for illuminant for specified primaries used.
     * If specified standard illuminant was not found, returns D65.
     *
     * @return array
     */
    public function getIlluminantTristimulus() : array {
        if($this->illuminant == null) {
            $this->illuminant = 'D65';
        }
        if(is_string($this->illuminant)) {
            $data = constant("\\tei187\\ColorTools\\StandardIlluminants\\Tristimulus2::".strtoupper($this->illuminant));
            if($data !== null) {
                return $data;
            }
        } elseif(is_array($this->illuminant)) {
            return $this->illuminant;
        }
        return \tei187\ColorTools\StandardIlluminants\WhitePoint2::D65;
    }
    /**
     * Returns gamma value.
     *
     * @return int|float|string
     */
    public function getGamma() {
        return $this->gamma;
    }
}