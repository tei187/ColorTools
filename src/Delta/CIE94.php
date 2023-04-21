<?php

namespace tei187\ColorTools\Delta;

use tei187\ColorTools\Helpers\ArrayMethods;

/**
 * CIE94 delta calculation methods.
 */
class CIE94 {
    /**
     * Calculation mode/application value for graphic arts.
     */
    const MODE_GRAPHIC_ARTS = "graphic_arts";
    /**
     * Calculation mode/application value for textiles.
     */
    const MODE_TEXTILES = "textiles";

    /**
     * Sum of allowed modes/applications.
     */
    const ALLOWED_MODES = [
        self::MODE_GRAPHIC_ARTS,
        self::MODE_TEXTILES
    ];

    /**
     * Weighing factors per mode/application.
     */
    const K_VALUES = [
        self::MODE_GRAPHIC_ARTS => [ 'k_L' => 1, 'K_1' => 0.045, 'K_2' => 0.015, ],
        self::MODE_TEXTILES =>     [ 'k_L' => 2, 'K_1' => 0.048, 'K_2' => 0.014, ],
    ];

    /**
     * Calculates dE using CIE94 algorithm based on two L\*a\*b measures.
     * 
     * @link https://en.wikipedia.org/wiki/Color_difference#CIE94
     *
     * @param array[] $data Regular array holding two arrays with keys `0` and `1` (reference and sample), each holding three measure values for L, a, b respectively.
     * @param string $mode Switch for application, allows `self::MODE_GRAPHIC_ARTS` (default) or `self::MODE_TEXTILES`, corresponding to `'graphic_arts'` or `'textiles'` strings respectively.
     * @return float
     */
    public static function calculateDelta(array $data, string $mode = self::MODE_GRAPHIC_ARTS) : float {
        $mode = !in_array(strtolower(trim($mode)), self::ALLOWED_MODES) ? self::MODE_GRAPHIC_ARTS : $mode;
        list($k_L, $K_1, $K_2) = self::K_VALUES[$mode];

        list($L1, $a1, $b1) = ArrayMethods::makeList($data[0], 'Lab');
        list($L2, $a2, $b2) = ArrayMethods::makeList($data[1], 'Lab');

        $k_C = 1;
        $k_H = 1;

        $L_delta = $L1 - $L2;
        $a_delta = $a1 - $a2;
        $b_delta = $b1 - $b2;
        $C_1 = sqrt(pow($a1, 2) + pow($b1, 2));
        $C_2 = sqrt(pow($a2, 2) + pow($b2, 2));
        $C_delta = $C_1 - $C_2;
        $H_delta = sqrt( pow($a_delta, 2) + pow($b_delta, 2) - pow($C_delta, 2) );
        $S_L = 1;
        $S_C = 1 + ($K_1 * $C_1);
        $S_H = 1 + ($K_2 * $C_1);

        return sqrt( 
            pow($L_delta / ($k_L * $S_L), 2) + 
            pow($C_delta / ($k_C * $S_C), 2) + 
            pow($H_delta / ($k_H * $S_H) , 2)
        );
    }
}
