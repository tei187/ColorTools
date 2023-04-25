<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;

class XYZ extends DeviceIndependentAbstract implements Measure {
    use Illuminants;

    protected $values = ['X' => 0, 'Y' => 0, 'Z' => 0];

    /**
     * Creates an XYZ swatch.
     *
     * @param array|null $values Input floats have to be arithmetic between -1 to 1.
     * @param array|string $illuminant Array with 2 values (x,y) or string corresponding a constant name in specific Standard Illuminants static class.
     * @param integer $observerAngle Standard observer angle.
     */
    public function __construct(array $values = [0,0,0], $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("XYZ");
        $this->setValues($values)
             ->setIlluminant($illuminant, $observerAngle);
    }

    // converters

    public function toXYZ() : self {
        return $this;
    }

    public function toxyY() : xyY {
        return (new xyY(Convert::XYZ_to_xyY($this->getValues())))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLab() : Lab {
        return (new Lab(Convert::XYZ_to_Lab($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh() : LCh {
        return (new LCh(Convert::XYZ_to_LCh($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLuv() : Luv {
        return (new Luv(Convert::XYZ_to_Luv($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh_uv() : LCh_uv {
        return (new LCh_uv(Convert::XYZ_to_LCh_uv($this->getValues(), $this->illuminantT)))
            ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
            ->setIlluminantName($this->illuminantName)
            ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toRGB($primaries = 'sRGB') : RGB {
        /*$primaries = self::loadPrimaries($primaries);
        if($primaries === false) {
            $primaries = new sRGB();
        }
        $primariesXYZ = [];
        if($this->illuminantName !== null) {
            if($primaries->getIlluminantName() !== $this->illuminantName) {
                foreach($primaries->getPrimariesXYY() as $values) {
                    $primariesXYZ[] = array_values(
                        Adaptation::adapt(
                            Convert::xyY_to_XYZ($values), 
                            $primaries->getIlluminantTristimulus(), 
                            constant("\\tei187\\ColorTools\\StandardIlluminants\\Tristimulus2::".$this->illuminantName)));
                }
            } else {
                foreach($primaries->getPrimariesXYY() as $values) {
                    $primariesXYZ[] = array_values(Convert::xyY_to_XYZ($values));
                }
            }
        } else {
            foreach($primaries->getPrimariesXYY() as $values) {
                $primariesXYZ[] = array_values(
                    Adaptation::adapt(
                        Convert::xyY_to_XYZ($values), 
                        $primaries->getIlluminantTristimulus(), 
                        $this->getIlluminantTristimulus()));
            }
        }
        
        $matrix = Adaptation::transpose3x3Matrix( Adaptation::invert3x3Matrix($primariesXYZ) );
        $xyz_rgb = Adaptation::matrixVector($matrix, array_values($this->getValues()));

        $outcome = [
            'R' => round( $primaries->applyCompanding($xyz_rgb[0], $primaries->getGamma()) * 255 ),
            'G' => round( $primaries->applyCompanding($xyz_rgb[1], $primaries->getGamma()) * 255 ),
            'B' => round( $primaries->applyCompanding($xyz_rgb[2], $primaries->getGamma()) * 255 )
        ];

        return
            new RGB($outcome, $primaries);
        */
        return new RGB(Convert::XYZ_to_RGB($this->getValues(), $primaries, $this->illuminantT), $primaries);
    }

    public function toHSL($primaries = 'sRGB') : HSL {
        return
        $this->toRGB($primaries)
             ->toHSL();
    }

    public function toHSV($primaries = 'sRGB') : HSV {
        return
            $this->toRGB($primaries)
                 ->toHSV();
    }
}