<?php

namespace tei187\ColorTools\ColorModels;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Math\ModelConversion;
use tei187\ColorTools\Abstracts\DeviceIndependent as DeviceIndependentAbstract;
use tei187\ColorTools\Traits\UsesIlluminant;

class Lab extends DeviceIndependentAbstract implements Measure {
    use UsesIlluminant;

    protected $values = ['L' => 0, 'a' => 0, 'b' => 0];

    /**
     * Creates a Lab swatch.
     *
     * @param array $values L: value between 0 and 100. a and b values between -100 to 100.
     * @param array|string|Illuminant $illuminant Array with 2 values (x,y) or string corresponding a constant name in specific Standard Illuminants static class.
     * @param integer $observerAngle Standard observer angle.
     */
    public function __construct(array $values = [0,0,0], $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("Lab")
             ->setValues($values)
             ->setIlluminant($illuminant, $observerAngle);
    }

    // converters

    public function toXYZ() : XYZ {
        return new XYZ(
            ModelConversion::Lab_to_XYZ(
                $this->getValues(), 
                $this->getIlluminant()->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toxyY() : xyY {
        return new xyY(
            ModelConversion::Lab_to_xyY(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ), 
            $this->illuminant
        );
    }

    public function toLab() : self {
        return $this;
    }

    public function toLCh() : LCh {
        return new LCh(
            ModelConversion::Lab_to_LCh(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLuv() : Luv {
        return new Luv(
            ModelConversion::Lab_to_Luv(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLCh_uv() : LCh_uv {
        return new LCh_uv(
            ModelConversion::Lab_to_LCh_uv(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toRGB($primaries = 'sRGB') : RGB {
        return 
        $this->toXYZ()
            ->setIlluminant($this->illuminant)
            ->toRGB($primaries);
    }

    public function toHSL($primaries = 'sRGB') : HSL {
        return
            $this->toRGB($primaries)
                 ->toHSL();
    }

    public function toHSV($primaries = 'sRGB') : HSV {
        return
            $this->toRGB($primaries)
                 ->toHSV();
    }
}