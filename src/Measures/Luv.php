<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Measures\MeasureAbstract;

class Luv extends MeasureAbstract implements Measure {
    use Illuminants;

    protected $values = ['L' => 0, 'u' => 0, 'v' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("Luv");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // converters

    public function toXYZ() : XYZ {
        return (new XYZ(Convert::Luv_to_XYZ($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);;;
    }

    public function toxyY() : xyY {
        return (new xyY(Convert::Luv_to_xyY($this->getValues())))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);;;
    }

    public function toLab() : Lab {
        return (new Lab(Convert::Luv_to_Lab($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);;;
    }

    public function toLCh() : LCh {
        return (new LCh(Convert::Luv_to_LCh($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);;;
    }

    public function toLuv() : self {
        return $this;
    }

    public function toLCh_uv() : LCh_uv {
        return (new LCh_uv(Convert::Luv_to_LCh_uv($this->getValues(), $this->illuminantT)))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);;;
    }

    public function toRGB($primaries = 'sRGB') : RGB {
        return $this->toXYZ()
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT)
            ->toRGB($primaries);
    }
}