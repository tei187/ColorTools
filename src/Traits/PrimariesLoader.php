<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Conversion\RGBPrimaries\Dictionary;
use tei187\ColorTools\Conversion\Convert;

/**
 * Handles RGB primaries loading.
 */
trait PrimariesLoader {
    /**
     * Loads primaries data.
     *
     * @param object|string|array $primaries Object of RGBPrimaries namespace, string that can be found in Dictionary or 3x3 array of arrays with xyY values or XYZ tristimulus for each RGB channel. If array and each channel's arrays do not have keys, XYZ is assumed.
     * @param string|null $name If creating a custom primaries set, sets a `name` parameter.
     * @param string|array|null $illuminant If creating a custom primaries set, sets a `illuminant` parameter. Can be a string (if Standard Illuminant defined in Dictionary) or XYZ tristimulus array.
     * @param float|integer|null $gamma If creating a custom primaries set, sets a `gamma` parameter.
     * @param string $expectedNamespace Some dirty argument that will check if passed object's class exists in set namespace (in case of a mix-up with similar class names).
     * @return object|false Will return object of RGBPrimaries namespace or false if loading failed.
     */
    static public function loadPrimaries($primaries, ?string $name = null, ?string $illuminant = null, $gamma = null, string $expectedNamespace = "tei187\\ColorTools\\Conversion\\RGBPrimaries\\Standard") {
        if(is_object($primaries)) {
            $className = explode("\\", get_class($primaries));
            $classNamespace = implode("\\", array_slice($className, 0, -1));
            if(Dictionary::assessPrimariesClass($className[array_key_last($className)]) && $classNamespace == $expectedNamespace) {
                // return object?
                $class = get_class($primaries);
                return new $class;
            } elseif($className[array_key_last($className)] == "Custom" && in_array("tei187\\ColorTools\\Interfaces\\Primaries", class_implements($primaries)) === true) {
                return $primaries;
            }
        } elseif(is_string($primaries)) {
            $className = Dictionary::assessPrimariesClass($primaries);
            if($className !== false) {
                // return object?
                $class = $expectedNamespace."\\".$className;
                return new $class;
            } // else false
        } elseif(is_array($primaries)) {
            // has to check if primaries passed are transcribed in form of xyY or XYZ
            $outcome = self::assessPrimariesSetType($primaries);
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
    static private function _assessPrimariesSetType(array $set) {
        $c = count($set);
        if($c === 3) {
            $setType = null;
            foreach($set as $channel) {
                //$current = null;
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

    static private function _verifyPrimariesObject($obj) {
        if(is_object($obj) && !in_array("tei187\\ColorTools\\Interfaces\\Primaries", class_implements($obj))) {
            return false;
        }
        if(is_string($obj)) {
            $primaries = self::loadPrimaries($obj);
            if($primaries === false) {
                return false;
            }
        }
        return true;
    }
}
