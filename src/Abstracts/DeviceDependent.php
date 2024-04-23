<?php

namespace tei187\ColorTools\Abstracts;

use tei187\ColorTools\Abstracts\DeviceIndependent as DeviceIndependentAbstract;
use tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries\sRGB;
use tei187\ColorTools\Helpers\ArrayMethods;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Traits\CalculatesDeltaE;

use tei187\ColorTools\ColorModels\XYZ;
use tei187\ColorTools\ColorModels\xyY;
use tei187\ColorTools\ColorModels\Lab;
use tei187\ColorTools\ColorModels\LCh;
use tei187\ColorTools\ColorModels\LCh_uv;
use tei187\ColorTools\ColorModels\Luv;
use tei187\ColorTools\ColorModels\RGB;
use tei187\ColorTools\ColorModels\HSL;
use tei187\ColorTools\ColorModels\HSV;
use tei187\ColorTools\Illuminants\Illuminant;

/**
 * Abstract class for device-dependent measures.
 */
abstract class DeviceDependent extends DeviceIndependentAbstract {
    use PrimariesLoader,
        CalculatesDeltaE;

    /**
     * RGB values.
     *
     * @var array
     */
    protected $values = [
        'R' => 0,
        'G' => 0,
        'B' => 0
    ];
    /**
     * Specific RGB primaries.
     *
     * @var object Object with primaries, based on \tei187\ColorTools\Interfaces\Primaries interface and \tei187\ColorTools\Conversion\RGBPrimaries\RGBPrimariesAbstract abstract class.
     */
    protected $primaries;

    /**
     * Returns specific primaries as object.
     * 
     * Returned object should be
     * - one of `\tei187\Colortools\Conversion\RGBPrimaries\Standard\`... classes
     * - custom primaries set of `\tei187\Colortools\Conversion\RGBPrimaries\Custom` class
     * - or separate object based on `\tei187\ColorTools\Interfaces\Primaries` interface and `\tei187\ColorTools\Conversion\RGBPrimaries\RGBPrimariesAbstract` abstract class.
     *
     * @return object
     */
    public function getPrimaries() : object {
        return $this->primaries;
    }

    public function getIlluminant(): Illuminant {
        return $this->primaries->getIlluminant();
    }

    /**
     * Sets primaries and primaries-based illuminant references (name, tristimulus).
     * 
     * **IMPORTANT:** this method does not cause chromatic adaptation between different white points and should only be used when creating a new object based on already adapted data.
     *
     * @param object|string $primaries RGB primaries object of tei187\ColorTools\Conversion\RGBPrimaries namespace or string corresponding to available primaries name/identifier.
     * @return self
     */
    public function setPrimaries($primaries) : self {
        $assessedPrimaries = $this->loadPrimaries($primaries);
        
        $this->primaries =
            $assessedPrimaries === false
                ? new sRGB
                : $assessedPrimaries;
        
        $this->setIlluminant($this->primaries->getIlluminant());
        return $this;
    }

    /**
     * Sets values for object.
     *
     * @param array|string $values Treats string as hexadecimal transcription of RGB (#rgb or #rrggbb)
     * @return self If input values are incorrect and do not fall under any interpretation, sets values as rgb(0,0,0).
     */
    public function setValues(...$values) : self {
        if(count($values) == 1) {
            $values = array_values($values)[0];
            if(is_string($values)) {
                $t = str_replace(["#", " "], "", trim($values));
                $t_l = strlen($t);
                if(ctype_xdigit($t)) {
                    if($t_l == 3 || $t_l == 4) {
                        $this->values = 
                            [
                                'R' => hexdec($t[0].$t[0]) / 255,
                                'G' => hexdec($t[1].$t[1]) / 255,
                                'B' => hexdec($t[2].$t[2]) / 255
                            ];
                    } elseif($t_l == 6 || $t_l == 8) {
                        $this->values = 
                            [
                                'R' => hexdec($t[0].$t[1]) / 255,
                                'G' => hexdec($t[2].$t[3]) / 255,
                                'B' => hexdec($t[4].$t[5]) / 255
                            ];
                    } else {
                        $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                    }
                } else {
                    $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                }
            } elseif ( is_array($values) ) {
                if(count($values) == 3) {
                    if(ArrayMethods::itemsBetween0and1($values)) {
                        $values = array_values($values);
                        $this->values = [
                            'R' => $values[0],
                            'G' => $values[1],
                            'B' => $values[2]
                        ];
                    } elseif(ArrayMethods::itemsBetween0and255($values)) {
                        $values = array_values($values);
                        $this->values = [
                            'R' => $values[0] / 255,
                            'G' => $values[1] / 255,
                            'B' => $values[2] / 255
                        ];
                    } else {
                        $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                    }
                } else {
                    $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                }
            } else {
                $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
            }
        } elseif(count($values) == 3) {
            if(ArrayMethods::itemsBetween0and1($values)) {
                $values = array_values($values);
                $this->values = [
                    'R' => $values[0],
                    'G' => $values[1],
                    'B' => $values[2]
                ];
            } elseif(ArrayMethods::itemsBetween0and255($values)) {
                $values = array_values($values);
                $this->values = [
                    'R' => $values[0] / 255,
                    'G' => $values[1] / 255,
                    'B' => $values[2] / 255
                ];
            } else {
                $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
            }
        }
        return $this;
    }

    /**
     * Converts to XYZ values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return XYZ
     */
    abstract public function toXYZ(): XYZ;
    /**
     * Converts to xyY values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return xyY
     */
    abstract public function toxyY(): xyY;
    /**
     * Converts to L\*a\*b values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return Lab
     */
    abstract public function toLab(): Lab;
    /**
     * Converts to L\*C\*h values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return LCh
     */
    abstract public function toLCh(): LCh;
    /**
     * Converts to LChUV values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return LCh_uv
     */
    abstract public function toLCh_uv(): LCh_uv;
    /**
     * Converts to Luv values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return Luv
     */
    abstract public function toLuv(): Luv;
    /**
     * Converts to RGB values in the same illuminant as default for specified RGB primaries set.
     *
     * @return RGB
     */
    abstract public function toRGB($primaries = 'sRGB'): RGB;
    /**
     * Converts to HSL values in the same illuminant as default for specified RGB primaries set.
     *
     * @return HSL
     */
    abstract public function toHSL($primaries = 'sRGB'): HSL;
    /**
     * Converts to HSV values in the same illuminant as default for specified RGB primaries set.
     *
     * @return HSV
     */
    abstract public function toHSV($primaries = 'sRGB'): HSV;
}