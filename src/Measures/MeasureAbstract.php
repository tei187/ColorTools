<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\ReturnsObjects;

abstract class MeasureAbstract {
    use Illuminants,
        ReturnsObjects;

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
    protected function _setValuesKeys(string $keys) : void {
        $keys = str_split(trim($keys));
        foreach($keys as $key) {
            $values[$key] = 0;
        }
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

    abstract public function toXYZ() : XYZ;
    abstract public function toxyY() : xyY;
    abstract public function toLab() : Lab;
    abstract public function toLCh() : Lch;
    abstract public function toLCh_uv() : LCh_uv;
    abstract public function toLuv() : Luv;
    abstract public function getTemperature();
}