<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;

class XYZ extends MeasureAbstract implements Measure {
    use Illuminants,
        ReturnsObjects;

    protected $values = ['X' => 0, 'Y' => 0, 'Z' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("XYZ");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // getters

    public function getTemperature() {
        return Temperature::XYZ_to_temp($this->getValues());
    }

    // converters

    public function toXYZ() : self {
        return $this;
    }

    public function toxyY() : xyY {
        return $this->returnAsxyY(Convert::XYZ_to_xyY($this->getValues()));
    }

    public function toLab() : Lab {
        return $this->returnAsLab(Convert::XYZ_to_Lab($this->getValues(), $this->illuminantT));
    }

    public function toLCh() : LCh {
        return $this->returnAsLCh(Convert::XYZ_to_LCh($this->getValues(), $this->illuminantT));
    }

    public function toLuv() : Luv {
        return $this->returnAsLuv(Convert::XYZ_to_Luv($this->getValues(), $this->illuminantT));
    }

    public function toLCh_uv() : LCh_uv {
        return $this->returnAsLCh_uv(Convert::XYZ_to_LCh_uv($this->getValues(), $this->illuminantT));
    }
}