<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Conversion\RGBPrimaries\Dictionary;
use tei187\ColorTools\Conversion\Convert;

/**
 * Handles primaries loading.
 */
trait PrimariesLoader {
    /**
     * Loads primaries data.
     *
     * @param object|string|array $primaries Object of RGBPrimaries namespace, string that can be found in Dictionary or 3x3 array of arrays with xyY values or XYZ tristimulus for each RGB channel. If array and each channel's arrays do not have keys, XYZ is assumed.
     * @param string|null $name If creating a custom primaries set, sets a `name` parameter.
     * @param string|null $illuminant If creating a custom primaries set, sets a `illuminant` parameter.
     * @param float|integer|null $gamma If creating a custom primaries set, sets a `gamma` parameter.
     * @return object|false Will return object of RGBPrimaries namespace or false if loading failed.
     */
    public function loadPrimaries($primaries, ?string $name = null, ?string $illuminant = null, $gamma = null) {
        if(is_object($primaries)) {
            $className = explode("\\", get_class($primaries));
            if(Dictionary::assessPrimariesClass($className[array_key_last($className)])) {
                // return object?
                $class = get_class($primaries);
                return new $class;
            } // else false
        } elseif(is_string($primaries)) {
            $className = Dictionary::assessPrimariesClass($primaries);
            if($className !== false) {
                // return object?
                $class = "\\tei187\\ColorTools\\Conversion\\RGBPrimaries\\sRGB\\".$className;
                return new $class;
            } // else false
        } elseif(is_array($primaries)) {
            // has to check if primaries passed are transcribed in form of xyY or XYZ
            $outcome = $this->_assessPrimariesSetType($primaries);
            if($outcome !== false) {
                $primaries_noIndex = array_values($primaries);
                $channels = ['R', 'G', 'B'];
                $xyY = [];
                switch($outcome) {
                    case 'xyz':
                        foreach($primaries_noIndex as $i => $values) {
                            $xyY[$channels[$i]] = Convert::XYZ_to_xyY($values);
                        }
                        break;
                    case 'xyy':
                        foreach($primaries_noIndex as $i => $values) {
                            $xyY[$channels[$i]] = $values;
                        }
                        break;
                }
                return new \tei187\ColorTools\Conversion\RGBPrimaries\Custom($xyY, $name, $illuminant, $gamma);
            }
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param array $set Set to check.
     * @return string|false
     */
    private function _assessPrimariesSetType(array $set) {
        $c = count($set);
        if($c === 3) {
            $setType = null;
            foreach($set as $channel) {
                $current = null;
                $keysSum = array_sum(array_keys($channel));
                $keys = implode("", array_map('strtolower', array_keys($channel)));
                if($keysSum == 3) {
                    if($setType !== null && $setType !== 'xyz') {
                        return false;
                    } else {
                        $setType = 'xyz';
                    }
                } else {
                    if(count($channel) == 3 && in_array($keys, ['xyz', 'xyy'])) {
                        if($setType == null) {
                            $setType = $keys;
                        } elseif($setType !== $keys) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            }
            return $setType;
        }
        return false;
    }
}
