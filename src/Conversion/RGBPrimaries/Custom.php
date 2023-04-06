<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;

use tei187\ColorTools\Interfaces\Primaries as PrimariesInterface;
use tei187\ColorTools\Traits\Companding\GammaCompanding;
use tei187\ColorTools\StandardIlluminants\Dictionary;

class Custom implements PrimariesInterface {
    use GammaCompanding;
    private $xyy = [];
    private $name = null;
    private $illuminant = null;
    private $gamma = 2.2;

    public function __construct(array $xyy, ?string $name = null, ?string $illuminant = null, float $gamma = 2.2) {
        $this->xyy = $xyy;
        $this->name = $name;
        $this->illuminant = 
            $illuminant === null || strlen(trim($illuminant)) == 0
                ? 'D65'
                : (
                    Dictionary::assessStandardIlluminant($illuminant) === false
                        ? 'D65'
                        : strtoupper(trim($illuminant))
                );
        $this->gamma = $gamma;
    }

    public function getPrimariesXYY() : array {
        return $this->xyy;
    }
    public function getPrimariesName() : ?string {
        return $this->name;
    }
    public function getIlluminantName() : ?string {
        return $this->illuminant;
    }
    public function getIlluminantTristimulus() : array {
        if($this->illuminant == null) {
            $this->illuminant = 'D65';
        }
        $data = constant("\\tei187\\ColorTools\\StandardIlluminants\\WhitePoint2::".strtoupper($this->illuminant));
        return \tei187\ColorTools\StandardIlluminants\WhitePoint2::D65;
    }
    public function getGamma() {
        return $this->gamma;
    }
}