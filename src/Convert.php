<?php

namespace tei187\ColorTools;

class Convert {
    /**
     * Converts data value from L\*C\*h to L\*a\*b.
     * 
     * @param array $data Array with 3 values corresponding to L, C, h.
     * @return array
     */
    public static function LChToLab(array $data) : array {
        list($L, $C, $h) = $data;
        return [
            'L' => $L,
            'a' => $C * cos(deg2rad($h)),
            'b' => $C * sin(deg2rad($h)),
        ];
    }
}
