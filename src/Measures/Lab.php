<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;

class Lab extends MeasureAbstract implements Measure {
    use Illuminants,
        ReturnsObjects;

    protected $values = ['L' => 0, 'a' => 0, 'b' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("Lab");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    

    public function getValues() : array {
        return $this->values;
    }

    public function toXYZ() : XYZ {
        return $this->returnAsXYZ(Convert::Lab_to_XYZ($this->getValues(), $this->illuminantT));
    }

    public function toxyY() : xyY {
        return $this->returnAsxyY(Convert::Lab_to_xyY($this->getValues()));
    }

    public function toLab() : self {
        return $this;
    }

    public function toLCh() : LCh {
        return $this->returnAsLCh(Convert::Lab_to_LCh($this->getValues(), $this->illuminantT));
    }

    public function toLuv() : Luv {
        return $this->returnAsLuv(Convert::Lab_to_Luv($this->getValues(), $this->illuminantT));
    }

    public function toLCh_uv() : LCh_uv {
        return $this->returnAsLCh_uv(Convert::Lab_to_Luv($this->getValues(), $this->illuminantT));
    }
}