<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;

class xyY extends DeviceIndependentAbstract implements Measure {
    use Illuminants;

    protected $values = ['x' => 0, 'y' => 0, 'Y' => 0];

    /**
     * Creates a xyY swatch.
     *
     * @param array $values
     * @param array|string $illuminant Array with 2 values (x,y) or string corresponding a constant name in specific Standard Illuminants static class.
     * @param integer $observerAngle Standard observer angle.
     */
    public function __construct(array $values = [0,0,0], $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("xyY");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // converters

    public function toXYZ() : XYZ {
        return (new XYZ(Convert::xyY_to_XYZ($this->getValues())))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toxyY() : self {
        return $this;
    }

    public function toLab() : Lab {
        return (new Lab(Convert::xyY_to_Lab($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh() : LCh {
        return (new LCh(Convert::xyY_to_LCh($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLuv() : Luv {
        return (new Luv(Convert::xyY_to_Luv($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh_uv() : LCh_uv {
        return (new LCh_uv(Convert::xyY_to_LCh_uv($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toRGB($primaries = 'sRGB') : RGB {
        return $this->toXYZ()
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT)
            ->toRGB($primaries);
    }

    public function toHSL($primaries = 'sRGB') : HSL {
        return $this->toRGB($primaries)->toHSL();
    }
}