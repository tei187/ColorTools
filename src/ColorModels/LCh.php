<?php

namespace tei187\ColorTools\ColorModels;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Math\ModelConversion;
use tei187\ColorTools\Traits\UsesIlluminant;
use tei187\ColorTools\Abstracts\DeviceIndependent as DeviceIndependentAbstract;

class LCh extends DeviceIndependentAbstract implements Measure {
    use UsesIlluminant;

    protected $values = ['L' => 0, 'C' => 0, 'h' => 0];

    /**
     * Creates a LCh swatch.
     *
     * @param array $values
     * @param array|string $illuminant Array with 2 values (x,y) or string corresponding a constant name in specific Standard Illuminants static class.
     * @param integer $observerAngle Standard observer angle.
     */
    public function __construct(array $values = [0,0,0], $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("LCh")
             ->setValues($values)
             ->setIlluminant($illuminant, $observerAngle);
    }

    // converters

    public function toXYZ() : XYZ {
        return new XYZ(
            ModelConversion::LCh_to_XYZ(
                $this->getValues(), 
                $this->illuminant->get('tristimulus')
            ), 
            $this->illuminant
        );
    }

    public function toxyY() : xyY {
        return new xyY(
            ModelConversion::LCh_to_xyY(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLab() : Lab {
        return new Lab(
            ModelConversion::LCh_to_Lab(
                $this->getValues(), 
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        ); 
    }

    public function toLCh() : self {
        return $this;
    }

    public function toLuv() : Luv {
        return new Luv(
            ModelConversion::LCh_to_Luv(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLCh_uv() : LCh_uv {
        return new LCh_uv(
            ModelConversion::LCh_to_LCh_uv(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toRGB($primaries = 'sRGB') : RGB {
        return $this->toXYZ()
            ->setIlluminant($this->illuminant)
            ->toRGB($primaries);
    }

    public function toHSL($primaries = 'sRGB') : HSL {
        return $this->toRGB($primaries)
                    ->toHSL();
    }

    public function toHSV($primaries = 'sRGB') : HSV {
        return $this->toRGB($primaries)
                    ->toHSV();
    }
}