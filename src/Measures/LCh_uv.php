<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;

class LCh_uv extends MeasureAbstract implements Measure {
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
        return Temperature::XYZ_to_temp(Convert::LCh_uv_to_XYZ($this->getValues(), $this->illuminantT));
    }

    // converters

    public function toXYZ() : XYZ {
        return $this->returnAsXYZ(Convert::LCh_uv_to_XYZ($this->getValues(), $this->illuminantT));
    }

    public function toxyY() : xyY {
        return $this->returnAsxyY(Convert::LCh_uv_to_xyY($this->getValues()));
    }

    public function toLab() : Lab {
        return $this->returnAsLab(Convert::LCh_uv_to_Lab($this->getValues(), $this->illuminantT));
    }

    public function toLCh() : LCh {
        return $this->returnAsLCh(Convert::LCh_uv_to_LCh($this->getValues(), $this->illuminantT));
    }

    public function toLuv() : Luv {
        return $this->returnAsLuv(Convert::LCh_uv_to_Luv($this->getValues(), $this->illuminantT));
    }

    public function toLCh_uv() : self {
        return $this;
    }
}