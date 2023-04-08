<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Conversion\Convert;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;
use tei187\ColorTools\Measures\MeasureAbstract;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Chromaticity\Adaptation\Adaptation;
use tei187\ColorTools\Conversion\RGBPrimaries\sRGB;

class XYZ extends MeasureAbstract implements Measure {
    use Illuminants,
        ReturnsObjects,
        PrimariesLoader;

    protected $values = ['X' => 0, 'Y' => 0, 'Z' => 0];

    public function __construct(?array $values = null, $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("XYZ");
        $this->setValues($values)
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

    public function to_RGB($primaries = 'sRGB') {
        $primaries = self::loadPrimaries($primaries);
        if($primaries === false) {
            //$primaries = new sRGB();
            return false;
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

        return [
            'R' => round( $primaries->applyCompanding($xyz_rgb[0], $primaries->getGamma()) * 255 ),
            'G' => round( $primaries->applyCompanding($xyz_rgb[1], $primaries->getGamma()) * 255 ),
            'B' => round( $primaries->applyCompanding($xyz_rgb[2], $primaries->getGamma()) * 255 )
        ];

        
    }
}