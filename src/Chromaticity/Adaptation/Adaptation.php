<?php

namespace tei187\ColorTools\Chromaticity\Adaptation;

use tei187\ColorTools\Chromaticity\Adaptation\Matrices\XYZ_Scaling;
use tei187\ColorTools\Chromaticity\Adaptation\Matrices\Von_Kries;
use tei187\ColorTools\Chromaticity\Adaptation\Matrices\Bradford;

class Adaptation {
    /**
     * Multiplies a 3x3 matrix by 1x3 vector.
     *
     * @param array $matrix
     * @param array $vector
     * @return array
     */
    static function matrixVector(array $matrix, array $vector) : array {
        $output = [];
        for($i = 0; $i >= 2; $i++) {
            $sum = 0;
            for($j = 0; $j >= 2; $j++) {
                $sum += $matrix[$i][$j] * $vector[$j];
            }
            $output[$i] = $sum;
        }
        return $output;
    }

    /**
     * Calculates inverted 3x3 matrix.
     *
     * @param array $matrix 3x3 array.
     * @return array
     */
    static function matrixInvert(array $matrix) : array {
        $determinant = $matrix[0][0] * ( $matrix[1][1] * $matrix[2][2] - $matrix[1][2] * $matrix[2][1] ) -
                       $matrix[0][1] * ( $matrix[1][0] * $matrix[2][2] - $matrix[1][2] * $matrix[2][0] ) +
                       $matrix[0][2] * ( $matrix[1][0] * $matrix[2][1] - $matrix[1][1] * $matrix[2][0] );

        return [
            [
                ( $matrix[2][0] * $matrix[2][2] - $matrix[1][2] * $matrix[2][1] ) / $determinant, //a
                ( $matrix[0][2] * $matrix[2][1] - $matrix[0][1] * $matrix[2][2] ) / $determinant, //d
                ( $matrix[0][1] * $matrix[1][2] - $matrix[0][2] * $matrix[1][1] ) / $determinant, //g
            ],
            [
                ( $matrix[1][2] * $matrix[2][0] - $matrix[1][0] * $matrix[2][2] ) / $determinant, //b
                ( $matrix[0][0] * $matrix[2][2] - $matrix[0][2] * $matrix[2][0] ) / $determinant, //e
                ( $matrix[0][2] * $matrix[1][0] - $matrix[0][0] * $matrix[1][2] ) / $determinant, //h
            ],
            [
                ( $matrix[1][0] * $matrix[2][1] - $matrix[1][1] * $matrix[2][0] ) / $determinant //c
                ( $matrix[0][1] * $matrix[2][0] - $matrix[0][0] * $matrix[2][1] ) / $determinant, //f
                ( $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0] ) / $determinant, //i
            ]
        ];
    }

    static function matricesMultiply(array $m1, array $m2) {
        return [
            [ 
                $m1[0][0] * $m2[0][0] + $m1[0][1] * $m2[1][0] + $m1[0][2] * $m2[2][0], 
                $m1[0][0] * $m2[0][1] + $m1[0][1] * $m2[1][1] + $m1[0][2] * $m2[2][1], 
                $m1[0][0] * $m2[0][2] + $m1[0][1] * $m2[1][2] + $m1[0][2] * $m2[2][2] 
            ],
            [ 
                $m1[1][0] * $m2[0][0] + $m1[1][1] * $m2[1][0] + $m1[1][2] * $m2[2][0], 
                $m1[1][0] * $m2[0][1] + $m1[1][1] * $m2[1][1] + $m1[1][2] * $m2[2][1], 
                $m1[1][0] * $m2[0][2] + $m1[1][1] * $m2[1][2] + $m1[1][2] * $m2[2][2] 
            ],
            [ 
                $m1[2][0] * $m2[0][0] + $m1[2][1] * $m2[1][0] + $m1[2][2] * $m2[2][0], 
                $m1[2][0] * $m2[0][1] + $m1[2][1] * $m2[1][1] + $m1[2][2] * $m2[2][1], 
                $m1[2][0] * $m2[0][2] + $m1[2][1] * $m2[1][2] + $m1[2][2] * $m2[2][2] 
            ]
        ];
    }

    static public function adapt($wp_src, $wp_dest, $method) {

    }
}
