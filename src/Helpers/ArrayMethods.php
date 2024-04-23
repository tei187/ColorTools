<?php

namespace tei187\ColorTools\Helpers;

/**
 * Handles checking if array is a list with corresponding length, or an associative array with specific order.
 */
class ArrayMethods {
    /**
     * Attempts to create a list from the provided data and keys.
     *
     * @param array $data The input data array.
     * @param array|string|int $keys The keys to use for the list, either as an array, a string representing the order, or an integer length to check against.
     * @return array|false The array list if successful, or false if the input data does not match the keys.
     */
    static function makeList($data, $keys)
    {
        $check = self::checkForKeys($data, $keys);
        switch ($check) {
            case 1:
                return array_values($data);
                break;
            default:
                return
                is_array($check) ? array_values($check) : false;
        }
    }

    /**
     * Transforms an array of data into a list-style array, using the provided keys.
     *
     * @param array $data The input data array to be transformed.
     * @param array|string $keys The keys to use for the transformed list-style array. Can be an array of keys or a string representing the keys.
     * @return array|false The transformed list-style array, or false if the transformation failed.
     */
    static function formList($data, $keys)
    {
        $check = self::makeList($data, $keys);
        if ($check !== false) {
            $keys = is_array($keys) ? $keys : str_split($keys);
            $output = [];
            foreach ($check as $k => $v) {
                $output[$keys[$k]] = $v;
            }
            return $output;
        }
        return false;
    }

    /**
     * Checks if the provided data array contains the specified keys, and returns `true` if so, or `false` if not.
     *
     * If the data is a regular array/list, it checks if the length of the data array matches the length of the keys array.
     * If the data is an associative array, it checks if all the keys in the keys array are present in the data array.
     * If the keys are not all present, it returns the values of the keys that are present. Don't ask me why, I don't recall.
     *
     * @param mixed $data The data to check the keys against.
     * @param mixed $keys The keys to check for in the data.
     * @return bool|array `true` if all keys are present, `false` if not, or an array of the values for the present keys.
     */
    static function checkForKeys($data, $keys)
    {
        if (self::isList($data)) {
            return count($data) == self::evalLength($keys)
                ? true
                : false;
        } else {
            $keys_s = array_keys($data);
            $keys_r = is_array($keys) ? array_values($keys) : self::evalArray($keys);
            if ($keys_s == $keys_r) {
                return true;
            } else {
                $output = [];
                foreach ($keys_r as $key_r) {
                    if (!in_array($key_r, $keys_s)) {
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
     * Converts the input to an array.
     *
     * If the input is a string, it will be split into an array of characters.
     * If the input is already an array, it will be returned as-is.
     * If the input is of any other type, it will return `false`.
     *
     * @param mixed $var The input to be converted to an array.
     * @return array|false The array representation of the input, or `false` if the input is not a string or array.
     */
    static function evalArray($var)
    {
        switch (gettype($var)) {
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
     * Evaluates the length of a variable, handling different data types (array, integer, string).
     *
     * @param mixed $var The variable to evaluate the length of.
     * @return int|false The length of the variable, or `false` if the type is not supported.
     */
    static function evalLength($var)
    {
        switch (gettype($var)) {
            case 'array':
                $length = count($var);
                break;
            case 'integer':
                $length = $var;
                break;
            case 'string':
                $length =
                (is_numeric($var) && ($var - ($var % 1) == 0)) // check if integer string
                ? $var
                : strlen(trim($var));
                break;
            default:
                return false;
        }
        return $length;
    }

    /**
     * Checks if the given array is a list, meaning its keys are sequential integers starting from 0.
     *
     * @param array $data The array to check.
     * @return bool `true` if the array is a list, `false` otherwise.
     */
    static function isList($data)
    {
        if (is_array($data)) {
            $c = count($data);
            if ($c > 0) {
                return range(0, count($data) - 1) == array_keys($data)
                    ? true
                    : false;
            }
        }
        return false;
    }

    /**
     * Checks if each element of the given array is a numeric value between 0 and 1.
     *
     * @param array $data The array to check.
     * @return bool `true` if all elements are numeric and between 0 and 1, `false` otherwise.
     */
    static function itemsBetween0and1(array $data): bool
    {
        $checks = array_map(function ($v) {
            return is_numeric($v) && $v >= 0 && $v <= 1
                ? true
                : false;
        }, $data);
        $uniques = array_unique(array_values($checks));

        return count($uniques) == 1 && $uniques[0] === true
            ? true
            : false;
    }


    /**
     * Checks if each element of the given array is a numeric value between 0 and 255.
     *
     * @param array $data The array to check.
     * @return bool `true` if all elements are numeric and between 0 and 255, `false` otherwise.
     */
    static function itemsBetween0and255(array $data): bool
    {
        $checks = array_map(function ($v) {
            return is_numeric($v) && $v >= 0 && $v <= 255 
                ? true 
                : false;
        }, $data);
        $uniques = array_unique(array_values($checks));

        return count($uniques) == 1 && $uniques[0] === true
            ? true
            : false;
    }


    /**
     * Checks if all elements in the given array are numeric.
     *
     * @param array $data The array to check.
     * @return bool `true` if all elements are numeric, `false` otherwise.
     */
    static function itemsNumeric(array $data): bool
    {
        $checks = array_map(function ($v) {
            return is_numeric($v);
        }, $data);
        $uniques = array_unique(array_values($checks));

        return count($uniques) == 1 && $uniques[0] === true
            ? true
            : false;
    }
}
