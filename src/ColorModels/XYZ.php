<?php

namespace tei187\ColorTools\ColorModels;

use tei187\ColorTools\Interfaces\Measure;
use tei187\ColorTools\Math\ModelConversion;
use tei187\ColorTools\Abstracts\DeviceIndependent as DeviceIndependentAbstract;
use tei187\ColorTools\Traits\UsesIlluminant;

class XYZ extends DeviceIndependentAbstract implements Measure {
    use UsesIlluminant;

    protected $values = ['X' => 0, 'Y' => 0, 'Z' => 0];

    /**
     * Creates an XYZ swatch.
     *
     * @param array|null $values Input floats have to be arithmetic between -1 to 1.
     * @param array|string|\tei187\ColorTools\StandardIlluminants\Illuminant $illuminant Array with 2 values (x,y) or string corresponding a constant name in specific Standard Illuminants static class.
     * @param integer $observerAngle Standard observer angle.
     */
    public function __construct(array $values = [0,0,0], $illuminant = null, int $observerAngle = 2 ) {
        $this->_setValuesKeys("XYZ");
        $this->setValues($values);
        $illuminant !== null ? $this->setIlluminant($illuminant, $observerAngle) : null;
    }

    // converters

    public function toXYZ() : self {
        return $this;
    }

    public function toxyY() : xyY {
        return new xyY(
            ModelConversion::XYZ_to_xyY($this->getValues()),
            $this->illuminant
        );  
    }

    public function toLab() : Lab {
        return new Lab(
            ModelConversion::XYZ_to_Lab(
                $this->getValues(), 
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLCh() : LCh {
        return new LCh(
            ModelConversion::XYZ_to_LCh(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLuv() : Luv {
        return new Luv(
            ModelConversion::XYZ_to_Luv(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
    }

    public function toLCh_uv() : LCh_uv {
        return new LCh_uv(
            ModelConversion::XYZ_to_LCh_uv(
                $this->getValues(),
                $this->illuminant->get('tristimulus')
            ),
            $this->illuminant
        );
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
                            ModelConversion::xyY_to_XYZ($values), 
                            $primaries->getIlluminantTristimulus(), 
                            constant("\\tei187\\ColorTools\\StandardIlluminants\\Tristimulus2::".$this->illuminantName)));
                }
            } else {
                foreach($primaries->getPrimariesXYY() as $values) {
                    $primariesXYZ[] = array_values(ModelConversion::xyY_to_XYZ($values));
                }
            }
        } else {
            foreach($primaries->getPrimariesXYY() as $values) {
                $primariesXYZ[] = array_values(
                    Adaptation::adapt(
                        ModelConversion::xyY_to_XYZ($values), 
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
        return new RGB(
            ModelConversion::XYZ_to_RGB(
                $this->getValues(), 
                $primaries, 
                $this->illuminant->get('tristimulus')
            ), 
            $primaries
        );
    }

    public function toHSL($primaries = 'sRGB') : HSL {
        return $this->toRGB($primaries)
                    ->toHSL();
    }

    public function toHSV($primaries = 'sRGB') : HSV {
        return $this->toRGB($primaries)
                    ->toHSV();
    }
}