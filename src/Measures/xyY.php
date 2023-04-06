<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;

class xyY extends MeasureAbstract implements Measure {
    use Illuminants,
        ReturnsObjects;

    protected $values = ['x' => 0, 'y' => 0, 'Y' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("xyY");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // getters

    public function getTemperature() {
        return Temperature::XYZ_to_temp(Convert::xyY_to_XYZ($this->getValues(), $this->illuminantT));
    }

    // converters

    public function getValues() : array {
        return $this->values;
    }

    public function toXYZ() : XYZ {
        return $this->returnAsXYZ(Convert::xyY_to_XYZ($this->getValues()));
    }

    public function toxyY() : self {
        return $this;
    }

    public function toLab() : Lab {
        return $this->returnAsLab(Convert::xyY_to_Lab($this->getValues(), $this->illuminantT));
    }

    public function toLCh() : LCh {
        return $this->returnAsLCh(Convert::xyY_to_LCh($this->getValues(), $this->illuminantT));
    }

    public function toLuv() : Luv {
        return $this->returnAsLuv(Convert::xyY_to_Luv($this->getValues(), $this->illuminantT));
    }

    public function toLCh_uv() : LCh_uv {
        return $this->returnAsLCh_uv(Convert::xyY_to_LCh_uv($this->getValues(), $this->illuminantT));
    }
}