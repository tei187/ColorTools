<?php

namespace tei187\ColorTools\StandardIlluminants;

class Dictionary {
    const CLASSES = [
        'A',
        'B',
        'C',
        'D50', 'D55', 'D65', 'D75', 'D93',
        'E',
        'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'F10', 'F11', 'F12',
        'LED_B1', 'LED_B2', 'LED_B3', 'LED_B4', 'LED_B5', 'LED_BH1', 'LED_RGB', 'LED_V1', 'LED_V2',
    ];

    public static function assessStandardIlluminant($name) {
        $as = "";
        if(is_string($name) && strlen(trim($name)) > 0) {
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
}