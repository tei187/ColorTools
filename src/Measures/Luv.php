<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;

class Luv extends MeasureAbstract implements Measure {
    use Illuminants,
        ReturnsObjects;

    protected $values = ['L' => 0, 'u' => 0, 'v' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("Luv");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // getters

    public function getTemperature() {
        return Temperature::XYZ_to_temp(Convert::Luv_to_XYZ($this->getValues(), $this->illuminantT));
    }

    // converters

    public function toXYZ() : XYZ {
        return $this->returnAsXYZ(Convert::Luv_to_XYZ($this->getValues(), $this->illuminantT));
    }

    public function toxyY() : xyY {
        return $this->returnAsxyY(Convert::Luv_to_xyY($this->getValues()));
    }

    public function toLab() : Lab {
        return $this->returnAsLab(Convert::Luv_to_Lab($this->getValues(), $this->illuminantT));
    }

    public function toLCh() : LCh {
        return $this->returnAsLCh(Convert::Luv_to_LCh($this->getValues(), $this->illuminantT));
    }

    public function toLuv() : self {
        return $this;
    }

    public function toLCh_uv() : LCh_uv {
        return $this->returnAsLCh_uv(Convert::Luv_to_LCh_uv($this->getValues(), $this->illuminantT));
    }
}