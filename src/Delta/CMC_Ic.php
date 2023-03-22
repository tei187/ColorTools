<?php

namespace tei187\ColorTools\Delta;

class CMC_lc {

    /**
     * Calculation mode/application value for acceptability.
     */
    const MODE_ACCEPTABILITY = "acceptability";
    /**
     * Calculation mode/application value for imperceptibility.
     */
    const MODE_IMPERCEPTIBILITY = "imperceptibility";
    /**
     * Sum of allowed modes/applications.
     */
    const ALLOWED_MODES = [ 
        self::MODE_ACCEPTABILITY,
        self::MODE_IMPERCEPTIBILITY,
    ];
    /**
     * Lightness and Chroma values, per selected mode.
     */
    const MODE_VALUES = [
        self::MODE_ACCEPTABILITY    => [ 'l' => 2, 'c' => 1, ],
        self::MODE_IMPERCEPTIBILITY => [ 'l' => 1, 'c' => 1, ],
    ];

    /**
     * Calculates dE using CMC l:c (1984) algorithm based on two L\*a\*b measures.
     * 
     * **IMPORTANT.** Take note that, typically, CMC l:c uses L\*C\*h scale in original equation. This method, for matters of consistency with other methods, uses L\*a\*b scale instead. Make sure to use a LCh-2-Lab converter, if your compared samples are in L\*C\*h.
     * 
     * @link http://www.brucelindbloom.com/index.html?Eqn_DeltaE_CMC.html
     *
     * @param array $data Regular array holding two arrays with keys `0` and `1` (reference and sample), each holding three measure values for L, a, b respectively.
     * @param string $mode Mode switch for 'l' (lightness) and 'c' (chroma) values used in equations. `self::MODE_ACCEPTABILITY` (default, string "acceptability") for 2:1, `self::MODE_IMPERCEPTABILITY` (string "imperceptability") for 1:1.
     * @return float
     */
    public static function calculateDelta(array $data, string $mode = self::MODE_ACCEPTABILITY) : float {
        $mode = !in_array(strtolower(trim($mode)), self::ALLOWED_MODES) ? self::MODE_ACCEPTABILITY : $mode;
        
        list($l, $c) = self::MODE_VALUES[$mode];

        list($L1, $a1, $b1) = $data[0];
        list($L2, $a2, $b2) = $data[1];

        $C_1 = sqrt(pow($a1, 2) + pow($b1, 2));
        $C_2 = sqrt(pow($a2, 2) + pow($b2, 2));
        
        $C_delta = $C_1 - $C_2;

        $L_delta = $L1 - $L2;
        $a_delta = $a1 - $a2;
        $b_delta = $b1 - $b2;

        $H_delta = sqrt( pow($a_delta, 2) + pow($b_delta, 2) - pow($C_delta, 2) );
        
        $H = rad2deg(atan2($b1, $a1));
        $H_1 = $H >= 0 ? $H : $H +360;

        $T = 
            $H_1 >= 164 && $H_1 <= 345
                ? 0.56 + abs( 0.2 * cos(deg2rad($H_1 + 168)) )
                : 0.36 + abs( 0.4 * cos(deg2rad($H_1 + 35)) );
        $F = sqrt( pow($C_1, 4) / (pow($C_1, 4) + 1900) );

        $S_L = $L1 < 16
            ? 0.511
            : (0.040975 * $L1) / (1 + (0.01765 * $L1));
        $S_C = (0.0638 * $C_1 / (1 + (0.0131 * $C_1))) + 0.638;
        $S_H = $S_C * ( $F * $T + 1 - $F);

        return sqrt(
            pow( $L_delta / ($l * $S_L), 2 ) +
            pow( $C_delta / ($c * $S_C), 2 ) +
            pow( $H_delta / $S_H, 2 )
        );
    }
}