<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Conversion\RGBPrimaries\Standard\sRGB;
use tei187\ColorTools\Helpers\ArrayMethods;

class HSL extends RGBMeasureAbstract {

    protected $values = [
        'H' => 0,
        'S' => 0,
        'L' => 0
    ];

    protected $primaries;

    public function __construct($values = [0,0,0], $primaries = 'sRGB') {
        $this->_setValuesKeys('HSL');
        $this->setValues($values);

        $assessedPrimaries = $this->loadPrimaries($primaries);

        $this->primaries =
        $assessedPrimaries === false
            ? new sRGB
            : $assessedPrimaries;
        $this->setIlluminant($this->primaries->getIlluminantName(), 2);
        $this->illuminantT = $this->primaries->getIlluminantTristimulus();
    }

    public function setValues(...$values) : self {
        $values = array_values($values);
        if(count($values) == 1 && is_array($values[0]) && ArrayMethods::itemsNumeric($values[0])) {
            $this->values = ArrayMethods::formList($values[0], 'HSL') ?: $this->values;
        } elseif (count($values) == 3 && ArrayMethods::itemsNumeric($values)) {
            $this->values = [
                'H' => $values[0],
                'S' => $values[1],
                'L' => $values[2]
            ];
        }
        return $this;
    }

    public function toXYZ() : XYZ {
        return (new XYZ())
            ->setValues(Convert::HSL_to_XYZ($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toxyY() : xyY {
        return (new xyY())
            ->setValues(Convert::HSL_to_xyY($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLab() : Lab {
        return (new Lab())
            ->setValues(Convert::HSL_to_Lab($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh() : LCh {
        return (new LCh())
            ->setValues(Convert::HSL_to_LCh($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh_uv() : LCh_uv {
        return (new LCh_uv())
            ->setValues(Convert::HSL_to_LCh_uv($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toRGB($primaries = null) : RGB {
        return (new RGB())
            ->setValues(Convert::HSL_to_RGB($this->getValues()))
            ->setPrimaries($this->primaries)
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLuv(): Luv {
        return 
            (new Luv())
                ->setValues(Convert::HSL_to_Luv($this->getValues(), $this->primaries))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toHSL($primaries = null): HSL {
        return $this;
    }
}