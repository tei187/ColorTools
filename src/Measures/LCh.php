<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;

class LCh extends MeasureAbstract implements Measure {
    use Illuminants,
        ReturnsObjects;

    protected $values = ['L' => 0, 'C' => 0, 'h' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("LCh");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // getters

    public function getTemperature() {
        return Temperature::XYZ_to_temp(Convert::LCh_to_XYZ($this->getValues(), $this->illuminantT));
    }

    // converters

    public function toXYZ() : XYZ {
        return $this->returnAsXYZ(Convert::LCh_to_XYZ($this->getValues(), $this->illuminantT));
    }

    public function toxyY() : xyY {
        return $this->returnAsxyY(Convert::LCh_to_xyY($this->getValues()));
    }

    public function toLab() : Lab {
        return $this->returnAsLab(Convert::LCh_to_Lab($this->getValues(), $this->illuminantT));
    }

    public function toLCh() : self {
        return $this;
    }

    public function toLuv() : Luv {
        return $this->returnAsLuv(Convert::LCh_to_Luv($this->getValues(), $this->illuminantT));
    }

    public function toLCh_uv() : LCh_uv {
        return $this->returnAsLCh_uv(Convert::LCh_to_LCh_uv($this->getValues(), $this->illuminantT));
    }
}