<?php

namespace tei187\ColorTools\StandardIlluminants;

use tei187\ColorTools\Conversion\Convert;

class Dictionary {
    /**
     * Array holding information about defined standard illuminants names.
     * 
     * @var string[]
     */
    const CLASSES = [
        'A',
        'B',
        'C',
        'D50', 'D55', 'D65', 'D75', 'D93',
        'E',
        'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'F10', 'F11', 'F12',
        'LED_B1', 'LED_B2', 'LED_B3', 'LED_B4', 'LED_B5', 'LED_BH1', 'LED_RGB', 'LED_V1', 'LED_V2',
    ];

    /**
     * Tries to asses if passed argument is a reference of standard illuminants available in dictionary.
     *
     * @param string $name Name of standard illuminant.
     * @return string|false Returns illuminant name, if assessed properly. Otherwise, returns boolean false.
     */
    public static function assessStandardIlluminant(string $name) {
        $as = "";
        if(is_string($name) && strlen(trim($name)) > 0) {
            $name = explode("|", $name)[0];
            if(array_search(strtoupper(trim($name)), self::CLASSES) === false) {
                return false;
            } else {
                $as = strtoupper(trim($name));
            }
        }

        return 
            $as !== ""
                ? $as
                : false;
    }

    private static function _checkString(string $s) : array {
        $out = [];
        $e = explode("|", $s);
        $out[0] =
            array_search(strtoupper(trim($e[0])), self::CLASSES)
                ? strtoupper(trim($e[0]))
                : null;
        $out[1] =
            isset($e[1]) && in_array($e[1], [2,10])
                ? $e[1]
                : null;
        return $out;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param integer $angle
     * @param string $baseFrom
     * @return array|false
     */
    private static function _retrieveConst($name, $angle, string $baseFrom = "\\tei187\\ColorTools\\StandardIlluminants\\WhitePoint") {
        $check = self::_checkString($name);
        if($check[0] === null) {
            $check = null;
        } else { 
            $name = $check[0];
            $angle = 
                $check[1] === null
                    ? ( in_array($angle, [2,10]) ? $angle : 2 )
                    : $check[1];
            $check = constant($baseFrom.$angle."::".strtoupper(trim($name)));
        }

        return is_null($check) ? false : $check;
    }

    /**
     * Attempts to retrieve specific chromatic coordinates of white point, per arguments used.
     *
     * @param string $name 
     * @param integer $angle
     * @return array|false
     */
    public static function getChromaticCoordinates(string $name, int $angle = 2) {
        return self::_retrieveConst($name, $angle);
    }

    /**
     * Attempts to retrieve specific chromatic coordinates of white point, per arguments used.
     *
     * @param string $name 
     * @param integer $angle
     * @return array|false
     */
    public static function getTristimulus(string $name, int $angle = 2) {
        $xy = self::_retrieveConst($name, $angle);
        if($xy !== false) {
            return Convert::chromaticity_to_tristimulus($xy);
        }
        return false;
    }
}