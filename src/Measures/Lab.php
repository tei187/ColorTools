<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Measures\MeasureAbstract;

class Lab extends MeasureAbstract implements Measure {
    use Illuminants;

    protected $values = ['L' => 0, 'a' => 0, 'b' => 0];

    public function __construct(array $values = [0,0,0], $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("Lab");
        $this
            ->setValues($values)
            ->setIlluminant($illuminant, $observerAngle);
    }

    // converters

    public function toXYZ() : XYZ {
        return (new XYZ(Convert::Lab_to_XYZ($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toxyY() : xyY {
        return (new xyY(Convert::Lab_to_xyY($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLab() : self {
        return $this;
    }

    public function toLCh() : LCh {
        return (new LCh(Convert::Lab_to_LCh($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLuv() : Luv {
        return (new Luv(Convert::Lab_to_Luv($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh_uv() : LCh_uv {
        return (new LCh_uv(Convert::Lab_to_LCh_uv($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toRGB($primaries = 'sRGB') : RGB {
        return 
        $this->toXYZ()
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT)
            ->toRGB($primaries);
    }

    public function toHSL($primaries = 'sRGB') : HSL {
        return
            $this->toRGB($primaries)
                 ->toHSL();
    }
}