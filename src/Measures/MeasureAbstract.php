<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Chromaticity\Temperature;
use tei187\ColorTools\Traits\ChromaticAdaptation;
use tei187\ColorTools\Traits\Delta;
use tei187\ColorTools\Traits\Illuminants;

abstract class MeasureAbstract {
    use Illuminants,
        ChromaticAdaptation,
        Delta;

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
     * @return void
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
     * Returns calculated temperature in K (Kelvin).
     *
     * @return float|integer
     */
    public function getTemperature() {
        return Temperature::XYZ_to_temp($this->toXYZ()->getValues());
    }
}
