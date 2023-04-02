<?php

namespace tei187\ColorTools\Chromaticity\Adaptation;

use tei187\ColorTools\Chromaticity\Adaptation\Matrices;

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

        for($i = 0; $i <= 2; $i++) {
            $sum = 0;
            for($j = 0; $j <= 2; $j++) {
                $sum += $matrix[$i][$j] * $vector[$j];
            }
            $output[$i] = $sum;
        }
        //var_dump($output);
        return $output;
    }

    /**
     * Calculates inverted 3x3 matrix.
     *
     * @param array $matrix 3x3 array.
     * @return array
     */
    static function matrix3x3Invert(array $matrix) : array {
        $determinant = $matrix[0][0] * ( $matrix[1][1] * $matrix[2][2] - $matrix[1][2] * $matrix[2][1] ) -
                       $matrix[0][1] * ( $matrix[1][0] * $matrix[2][2] - $matrix[1][2] * $matrix[2][0] ) +
                       $matrix[0][2] * ( $matrix[1][0] * $matrix[2][1] - $matrix[1][1] * $matrix[2][0] );
        /*$determinant = ( $matrix[0][0] * $matrix[1][1] * $matrix[2][2] ) + 
                       ( $matrix[0][1] * $matrix[1][2] * $matrix[2][0] ) +
                       ( $matrix[0][2] * $matrix[1][0] * $matrix[2][1] ) -
                       ( $matrix[0][0] * $matrix[1][2] * $matrix[2][1] ) - 
                       ( $matrix[0][1] * $matrix[1][0] * $matrix[2][2] ) -
                       ( $matrix[0][2] * $matrix[1][1] * $matrix[2][0] );*/

        return [
            [
                ( $matrix[1][1] * $matrix[2][2] - $matrix[1][2] * $matrix[2][1] ) / $determinant,
                ( $matrix[0][2] * $matrix[2][1] - $matrix[0][1] * $matrix[2][2] ) / $determinant,
                ( $matrix[0][1] * $matrix[1][2] - $matrix[0][2] * $matrix[1][1] ) / $determinant,
            ],
            [
                ( $matrix[1][2] * $matrix[2][0] - $matrix[1][0] * $matrix[2][2] ) / $determinant,
                ( $matrix[0][0] * $matrix[2][2] - $matrix[0][2] * $matrix[2][0] ) / $determinant,
                ( $matrix[0][2] * $matrix[1][0] - $matrix[0][0] * $matrix[1][2] ) / $determinant,
            ],
            [
                ( $matrix[1][0] * $matrix[2][1] - $matrix[1][1] * $matrix[2][0] ) / $determinant,
                ( $matrix[0][1] * $matrix[2][0] - $matrix[0][0] * $matrix[2][1] ) / $determinant,
                ( $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0] ) / $determinant,
            ]
        ];
    }

    /**
     * Multiplies two 3x3 matrices.
     *
     * @param array $m1 3x3 matrix.
     * @param array $m2 3x3 matrix.
     * @return array
     */
    static function matrices3x3Multiply(array $m1, array $m2) : array {
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

    /**
     * Linear/simplified Bradford chromatic adaptation transformation, based on LMS.
     *
     * @param array $XYZ Swatch XYZ values.
     * @param array $WP_s XYZ of source white point for specific standard observer. If only `xy` transcription is available, make sure to use `chromaticity_to_tristimulus` function.
     * @param array $WP_d XYZ of destination white point for specific standard observer. If only `xy` transcription is available, make sure to use `chromaticity_to_tristimulus` function.
     * @param array $M_tran Trasnformation matrix.
     * @return array array 
     * 
     * @see https://en.wikipedia.org/wiki/Chromatic_adaptation Chromatic_adaptation @ Wikipedia
     * @see http://www.brucelindbloom.com/ Bruce Lindbloom's Web Site
     * @see https://www.nixsensor.com/free-color-converter/ Free Color Converter - RGB, CMYK, LAB, XYZ, HEX and more!
     * @see https://onlinelibrary.wiley.com/doi/pdfdirect/10.1002/9781119021780.app3 The Bradford Colour Adaptation Transform | Excerpt from *Colour Reproduction in Electronic Imaging Systems: Photography, Television, Cinematography*, First Edition, by Michael S Tooms
     */
    static public function adapt(array $XYZ, array $WP_s, array $WP_d, array $M_tran = Matrices::Bradford) {
        list($rho_s, $gamma_s, $beta_s) = self::matrixVector($M_tran, $WP_s);
        list($rho_d, $gamma_d, $beta_d) = self::matrixVector($M_tran, $WP_d);

        $r = $rho_d / $rho_s;
        $g = $gamma_d / $gamma_s;
        $b = $beta_d / $beta_s;

        $M_ADT = [
            [ $r, .0, .0 ], 
            [ .0, $g, .0 ], 
            [ .0, .0, $b ]
        ];

        //$step1 = self::matrices3x3Multiply(self::matrix3x3Invert($M_tran), $M_ADT);
        //$step2 = self::matrices3x3Multiply($step1, $M_tran);
        //$step3 = self::matrixVector($step2, $XYZ);

        $outcome = 
            self::matrixVector( 
                self::matrices3x3Multiply( 
                    self::matrices3x3Multiply( 
                        self::matrix3x3Invert( $M_tran ), 
                        $M_ADT ), 
                    $M_tran ), 
                $XYZ );

        return [
            'X' => $outcome[0],
            'Y' => $outcome[1],
            'Z' => $outcome[2]
        ];
    }
}
