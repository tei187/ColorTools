<?php

namespace tei187\ColorTools\Abstracts;

use tei187\ColorTools\Math\Chromaticity\Temperature;
use tei187\ColorTools\Traits\ChromaticAdaptation;
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
use tei187\ColorTools\Interfaces\Illuminant as IlluminantInterface;
use tei187\ColorTools\Interfaces\StandardIlluminant as StandardIlluminantInterface;
use tei187\ColorTools\Traits\CalculatesContrast;
use tei187\ColorTools\Traits\UsesIlluminant;

/**
 * Abstract class for device independent measures.
 */
abstract class DeviceIndependent {
    use UsesIlluminant,
        ChromaticAdaptation,
        CalculatesDeltaE,
        CalculatesContrast;

    protected $values = [];

    /**
     * Returns array with values.
     *
     * @return array
     */
    public function getValues() : array {
        return $this->values;
    }

    /**
     * Assigns keys for array property 'values' per string input (assumed only one-character keys).
     *
     * @param string $keys
     * @return self
     */
    protected function _setValuesKeys(string $keys) : self {
        $keys = str_split(trim($keys));
        foreach($keys as $key) {
            $values[$key] = 0;
        }
        return $this;
    }

    /**
     * Sets values to measure.
     *
     * @param int|float|array ...$values Set of values representing each type. Alternatively one array with corresponding values.
     * @return self|false Returns self if input is proper, boolean false otherwise.
     */
    public function setValues(...$values) {
        $keys = array_keys($this->values);
        if(count($keys) == func_num_args()) {
            $toCheck = $values;
        } elseif( isset($values[0]) && is_array($values[0]) && count($keys) == count($values[0]) ) {
            $toCheck = $values[0];
        } else {
            $toCheck = str_split(str_repeat("0", count($keys)));
        }
        
        $composed = $this->_checkValues($toCheck);
        if($composed !== false) {
            foreach($composed as $i => $value) {
                $this->values[$keys[$i]] = $value;
            }
            return $this;
        }
        return false;
    }

    protected function _checkValues(array $arr) {
        $arr = array_values($arr);
        $composed = [];
        foreach($arr as $key => $value) {
            if(!is_float($value) && !is_int($value)) {
                if(is_null($value) || (is_string($value) && strlen($value) == 0)) {
                    $composed[$key] = 0;
                } else {
                    return false; // function breaks, wrong arguments
                }
            } else {
                $composed[$key] = $value;
            }
        }
        return $composed;
    }

    public function getMeasureType() : string {
        $e = explode("\\", get_class($this));
        return $e[array_key_last($e)];
    }

    /**
     * Retrieves illuminant object.
     *
     * @return IlluminantInterface|StandardIlluminantInterface
     */
    public function getIlluminant() {
        return $this->illuminant;
    }

    /**
     * Converts to specified color model.
     *
     * @param string $class
     * @param string|object $primaries
     * @return object|null
     */
    public function to($class, $primaries = 'sRGB') : ?object {
        $out = null;
        switch (strtolower($class)) {
            case 'lab':     $out = $this->toLab(); break;
            case 'lch':     $out = $this->toLCh(); break;
            case 'lch_uv':  $out = $this->toLCh_uv(); break;
            case 'luv':     $out = $this->toLuv(); break;
            case 'xyy':     $out = $this->toxyY(); break;
            case 'xyz':     $out = $this->toXYZ(); break;
            case 'rgb':     $out = $this->toRGB($primaries); break;
        }
        return $out;
    }
    /**
     * Converts from specified color model to XYZ.
     *
     * @return XYZ
     */
    abstract public function toXYZ() : XYZ;
    /**
     * Converts from specified color model to xyY.
     *
     * @return xyY
     */
    abstract public function toxyY() : xyY;
    /**
     * Converts from specified color model to L*a*b.
     *
     * @return Lab
     */
    abstract public function toLab() : Lab;
    /**
     * Converts from specified color model to LCh.
     *
     * @return Lch
     */
    abstract public function toLCh() : Lch;
    /**
     * Converts from specified color model to LCh UV.
     *
     * @return LCh_uv
     */
    abstract public function toLCh_uv() : LCh_uv;
    /**
     * Converts from specified color model to Luv.
     *
     * @return Luv
     */
    abstract public function toLuv() : Luv;
    /**
     * Converts from specified color model to RGB model, based on RGB primaries set.
     *
     * @param object|string $primaries
     * @return RGB
     */
    abstract public function toRGB($primaries = 'sRGB') : RGB;
    /**
     * Converts from specified color model to HSL model, based on RGB primaries set.
     *
     * @param object|string $primaries
     * @return HSL
     */
    abstract public function toHSL($primaries = 'sRGB') : HSL;
    /**
     * Converts from specified color model to HSV model, based on RGB primaries set.
     *
     * @param object|string $primaries
     * @return HSV
     */
    abstract public function toHSV($primaries = 'sRGB') : HSV;
    /**
     * Returns calculated temperature in K (Kelvin).
     *
     * @return float|integer
     */
    public function getTemperature() {
        return Temperature::XYZ_to_temp($this->toXYZ()->getValues());
    }
}
