<?php

namespace tei187\ColorTools\Helpers;

/**
 * Handles checking if array is a list with corresponding length, or an associative array with specific order.
 */
class ArrayMethods {
    /**
     * Validates structure of array, per specified profile (keys count or order).
     *
     * @param array $data If array, checks if proper.
     * @param array|string|int $keys Array of keys in specified order, string representing keys order or integer length of array to check against.
     * @return array|false If input is proper and checks out, returns list-like array. If not, returns FALSE.
     */
    static function makeList($data, $keys) {
        $check = self::checkForKeys($data, $keys);
        switch($check) {
            case 1: return array_values($data); break;
            default:
                return
                    is_array($check) ? array_values($check) : false;
        }
    }

    static function formList($data, $keys) {
        $check = self::makeList($data, $keys);
        if($check !== false) {
            $keys = is_array($keys) ? $keys : str_split($keys);
            $output = [ ];
            foreach($check as $k => $v) {
                $output[$keys[$k]] = $v;
            }
            return $output;
        }
        return false;
    }

    /**
     * Validates array for length and corresponding keys? Can't remember anymore.
     *
     * @param array $data
     * @param array|string|int $keys Array of keys in specified order, string representing keys order or integer length of array to check against.
     * @return boolean|array True if input array is a match, false if it is not, specific part of array if not exact match (if input array is bigger than required profile).
     */
    static function checkForKeys($data, $keys) {
        if(self::isList($data)) {
            return
                count($data) == self::evalLength($keys)
                    ? true
                    : false;
        } else {
            $keys_s = array_keys($data);
            $keys_r = is_array($keys) ? array_values($keys) : self::evalArray($keys);
            if($keys_s == $keys_r) {
                return true;
            } else {
                $output = [];
                foreach($keys_r as $key_r) {
                    if(!in_array($key_r, $keys_s)) {
                        return false;
                    } else {
                        $output[] = $data[$key_r];
                    }
                }
                return $output;
            }
        }
        return false;
    }

    /**
     * Does its best to evaluate input as array, in a way I need it to. Nosy...
     *
     * @param mixed $var
     * @return array|false
     */
    static function evalArray($var) {
        switch(gettype($var)) {
            case "string":
                    return str_split($var);
                break;
            case "array":
                    return $var;
                break;
            default: 
                return false;
        }
    }

    /**
     * Evalues input as length of an array.
     *
     * @param mixed $var
     * @return integer|false;
     */
    static function evalLength($var) {
        switch(gettype($var)) {
            case 'array':   $length = count($var); break;
            case 'integer': $length = $var; break;
            case 'string':  
                $length = 
                    ( is_numeric($var) && ($var - ($var % 1) == 0) ) // check if integer string
                        ? $var 
                        : strlen(trim($var)); 
                break;
            default:
                return false;
        }
        return $length;
    }

    /**
     * Quick check if input is a regular array / list.
     *
     * @param mixed $data
     * @return boolean TRUE if regular array, FALSE if different type or empty array.
     */
    static function isList($data) {
        if(is_array($data)) {
            $c = count($data);
            if($c > 0) {
                return 
                    range(0, count($data)-1) == array_keys($data)
                        ? true
                        : false;
            }
        }
        return false;
    }

    /**
     * Checks if each element of array is a numeric value between 0 and 1.
     * 
     * @param array $data
     * @return boolean
     */
    static function itemsBetween0and1(array $data) : bool {
        $checks = array_map(function($v) {return is_numeric($v) && $v >= 0 && $v <= 1 ? true : false;}, $data);
        $uniques = array_unique(array_values($checks));
        
        return 
            count($uniques) == 1 && $uniques[0] === true
                ? true
                : false;
    }

    /**
     * Checks if each element of array is a numeric value between 0 and 255.
     *
     * @param array $data
     * @return boolean
     */
    static function itemsBetween0and255(array $data) : bool {
        $checks = array_map(function($v) {return is_numeric($v) && $v >= 0 && $v <= 255 ? true : false;}, $data);
        $uniques = array_unique(array_values($checks));

        return 
            count($uniques) == 1 && $uniques[0] === true
                ? true
                : false;
    }

    /**
     * Checks if each element of array is numeric.
     *
     * @param array $data
     * @return boolean
     */
    static function itemsNumeric(array $data) : bool {
        $checks = array_map(function($v) { return is_numeric($v); }, $data);
        $uniques = array_unique(array_values($checks));

        return 
            count($uniques) == 1 && $uniques[0] === true
                ? true
                : false;
    }
}
