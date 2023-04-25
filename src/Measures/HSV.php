<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Helpers\ArrayMethods;

class HSV extends DeviceDependentAbstract {
    /**
     * HSV values.
     *
     * @var array
     */
    protected $values = [
        'H' => 0,
        'S' => 0,
        'L' => 0
    ];

    protected $primaries;

    /**
     * Creates a HSV swatch.
     *
     * @param array $values An array with HSV values (in this order), where H takes a numeric value between 0 and 360 (degrees), S and V a float value between 0 and 1 (equivalent of percentage).
     * @param object|string $primaries RGB primaries to be used in conversion. By default sRGB.
     */
    public function __construct($values = [0,0,0], $primaries = 'sRGB') {
        $this->_setValuesKeys('HSV');
        $this->setValues($values);
        $this->setPrimaries($primaries);
    }

    /**
     * Sets values for object.
     *
     * @param array ...$values Set of values representing each type. Alternatively one array with corresponding values.
     * @return self
     */
    public function setValues(...$values) : self {
        $values = array_values($values);
        if(count($values) == 1 && is_array($values[0]) && ArrayMethods::itemsNumeric($values[0])) {
            $this->values = ArrayMethods::formList($values[0], 'HSV') ?: $this->values;
        } elseif (count($values) == 3 && ArrayMethods::itemsNumeric($values)) {
            $this->values = [
                'H' => $values[0],
                'S' => $values[1],
                'V' => $values[2]
            ];
        }
        return $this;
    }

    public function toXYZ() : XYZ {
        return (new XYZ())
            ->setValues(Convert::HSV_to_XYZ($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toxyY() : xyY {
        return (new xyY())
            ->setValues(Convert::HSV_to_xyY($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLab() : Lab {
        return (new Lab())
            ->setValues(Convert::HSV_to_Lab($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh() : LCh {
        return (new LCh())
            ->setValues(Convert::HSV_to_LCh($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh_uv() : LCh_uv {
        return (new LCh_uv())
            ->setValues(Convert::HSV_to_LCh_uv($this->getValues(), $this->getPrimaries()))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toRGB($primaries = null) : RGB {
        return (new RGB())
            ->setValues(Convert::HSV_to_RGB($this->getValues()))
            ->setPrimaries($this->primaries)
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLuv(): Luv {
        return 
            (new Luv())
                ->setValues(Convert::HSV_to_Luv($this->getValues(), $this->primaries))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toHSL($primaries = null): HSL {
        return
            (new HSL())
                ->setValues(Convert::HSV_to_HSL($this->getValues()))
                ->setPrimaries($this->primaries)
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toHSV($primaries = null): HSV {
        return $this;
    }

    /**
     * Returns HSV values array with formatted strings.
     *
     * @param integer|false $round If integer, rounds to specified precision. If false, leaves original values.
     * @return array
     */
    public function getValuesFormatted($round = false) : array {
        list($H, $S, $V) = array_values($this->values);

        $S = $S * 100;
        $V = $V * 100;

        if($round !== false && is_int($round) && $round >= 0) {
            $H = round($H, $round);
            $S = round($S, $round);
            $V = round($V, $round);
        }

        return [
            'H' => $H . "°",
            'S' => $S . "%",
            'V' => $V . "%"
        ];
    }
}