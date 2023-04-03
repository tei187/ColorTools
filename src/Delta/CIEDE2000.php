<?php

namespace tei187\ColorTools\Delta;

use tei187\ColorTools\Helpers\CheckArray;

class CIEDE2000 {
    /**
     * Calculates dE using CIEDE2000 algorithm based on two L\*a\*b measures.
     *
     * @link https://en.wikipedia.org/wiki/Color_difference#CIEDE2000 Wikipedia article on color difference measurement and calculation.
     * @link https://hajim.rochester.edu/ece/sites/gsharma/ciede2000/ciede2000noteCRNA.pdf **The CIEDE2000 Color-Difference Formula: Implementation Notes, Supplementary Test Data, and Mathematical Observations** | *Gaurav Sharma, Wencheng Wu, Edul N. Dalal*
     * @link https://hajim.rochester.edu/ece/sites/gsharma/ciede2000/dataNprograms/CIEDE2000.xls **Excel spreadsheet implementation of the CIEDE2000 color-difference formula (including test data)** | *Gaurav Sharma*
     * 
     * @param array $data Regular array holding two arrays with keys `0` and `1` (reference and sample), each holding three measure values for L, a, b respectively.
     * @return float
     */
    public static function calculateDelta(array $data) {
        list($L1, $a1, $b1) = CheckArray::makeList($data[0], 'Lab');
        list($L2, $a2, $b2) = CheckArray::makeList($data[1], 'Lab');

        $C_1 = sqrt(pow($a1,2) + pow($b1, 2)); // (2)
        $C_2 = sqrt(pow($a2,2) + pow($b2, 2)); // (2)
        $C_avg = ($C_1 + $C_2) / 2; // (3)
        $C_avg_pow7 = pow($C_avg, 7);
        $pow25_7 = pow(25, 7);

        $G = .5 * (1 - sqrt($C_avg_pow7 / ($C_avg_pow7 + $pow25_7))); // (4)

        $ap_1 = (1 + $G) * $a1; // (5)
        $ap_2 = (1 + $G) * $a2; // (5)

        $Cp_1 = sqrt(pow($ap_1,2) + pow($b1,2)); // (6)
        $Cp_2 = sqrt(pow($ap_2,2) + pow($b2,2)); // (6)

        $hp_1 = 
            ($ap_1 == 0 && $b1 == 0)
                ? 0
                : (
                    ($b1 >= 0)
                        ? rad2deg(atan2($b1, $ap_1))
                        : rad2deg(atan2($b1, $ap_1)) + 360
                ); // (7)
        $hp_2 = 
            ($ap_2 == 0 && $b2 == 0)
                ? 0
                : (
                    ($b2 >= 0)
                        ? rad2deg(atan2($b2, $ap_2))
                        : rad2deg(atan2($b2, $ap_2)) + 360
                ); // (7)

        $Lp_delta = $L2 - $L1; // (8)
        $Cp_delta = $Cp_2 - $Cp_1; // (9)
        
        if($Cp_1 * $Cp_2 == 0) {
            $hp_delta = 0;
        } else {
                if(abs($hp_2 - $hp_1) <= 180) { $hp_delta = $hp_2 - $hp_1; }
            elseif(($hp_2 - $hp_1) >  180)    { $hp_delta = $hp_2 - $hp_1 - 360; }
            elseif(($hp_2 - $hp_1) < -180)    { $hp_delta = $hp_2 - $hp_1 + 360; }
        } // (10)

        $Hp_delta = 2 * sqrt($Cp_1 * $Cp_2) * sin(deg2rad($hp_delta / 2)); // (11)

        $Lp_avg = ($L1 + $L2) / 2; // (12)
        $Cp_avg = ($Cp_1 + $Cp_2) / 2; // (13)

        if(abs($hp_1 - $hp_2) <= 180 && ($Cp_1 * $Cp_2) !== 0) {
            $hp_avg = ($hp_1 + $hp_2) / 2;
        } elseif(abs($hp_1 - $hp_2) > 180 && ($hp_1 + $hp_2) < 360 && ($Cp_1 * $Cp_2) !== 0) {
            $hp_avg = ($hp_1 + $hp_2 + 360) / 2;
        } elseif(abs($hp_1 - $hp_2) > 180 && ($hp_1 + $hp_2) >= 360 && ($Cp_1 * $Cp_2) !== 0) {
            $hp_avg = ($hp_1 + $hp_2 - 360) / 2;
        } elseif(($Cp_1 * $Cp_2) == 0) {
            $hp_avg = $hp_1 + $hp_2;
        } // (14)

        $T = 1 - (0.17 * cos(deg2rad($hp_avg - 30))) + (0.24 * cos(deg2rad(2 * $hp_avg))) + (0.32 * cos(deg2rad(3 * $hp_avg + 6))) - (0.2 * cos(deg2rad(4 * $hp_avg - 63))); // (15)

        $Theta_delta = 30 * exp(-1 * pow(($hp_avg - 275) / 25, 2)); // (16)
        $R_C = 2 * sqrt( pow($Cp_avg, 7) / (pow($Cp_avg, 7) + $pow25_7)); // (17)
        $S_L = 1 + ((0.015 * pow($Lp_avg - 50, 2)) / sqrt(20 + pow($Lp_avg - 50, 2))); // (18)
        $S_C = 1 + (0.045 * $Cp_avg); // (19)
        $S_H = 1 + (0.015 * $Cp_avg * $T); // (20)
        $R_T = -1 * (sin(deg2rad(2 * $Theta_delta))) * $R_C; // (21)

        return sqrt(
            pow($Lp_delta / $S_L, 2) + 
            pow($Cp_delta / $S_C, 2) + 
            pow($Hp_delta / $S_H, 2) + 
            $R_T * ($Cp_delta / $S_C) * ($Hp_delta / $S_H)
        ); // (22)
    }
}
