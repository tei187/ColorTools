<?php

namespace tei187\ColorTools\Chromaticity\Adaptation;

use tei187\ColorTools\Chromaticity\Adaptation\Matrices;
use tei187\ColorTools\Conversion\Convert;

/**
 * Chromatic adaptation handler.
 * 
 * @see https://www.xrite.com/pl-pl/service-support/chromaticadaptationwhatisitwhatdoesitdo
 * @see http://www.russellcottrell.com/photo/matrixCalculator.htm
 * @see https://www.wikihow.com/Find-the-Inverse-of-a-3x3-Matrix Math based on article.
 */
class Adaptation {
    /**
     * Multiplies a 3x3 matrix by 1x3 vector.
     *
     * @param array $matrix 3x3 array.
     * @param array $vector Array with 3 values (treated as column).
     * @return array
     */
    static function matrixVector(array $matrix, array $vector) : array {
        $output = [];

        $temp = [];
        foreach($matrix as $row) {
            $temp[] = array_values($row);
        };
        $matrix = $temp;
        unset($temp, $row);

        $vector = array_values($vector);

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
     * Transposes a 3x3 matrix.
     *
     * @param array $matrix
     * @return array
     */
    static function transpose3x3Matrix(array $matrix) : array {
        return 
        [
            [ $matrix[0][0], $matrix[1][0], $matrix[2][0] ],
            [ $matrix[0][1], $matrix[1][1], $matrix[2][1] ],
            [ $matrix[0][2], $matrix[1][2], $matrix[2][2] ]
        ];
    }

    /**
     * Finds determinant for 2x2 matrix.
     *
     * @param array $matrix
     * @return integer|float
     */
    static function find2x2MatrixDeterminant(array $matrix) {
        return $matrix[0][0] * $matrix[1][1] - ($matrix[0][1] * $matrix[1][0]);
    }

    /**
     * Every item of 3x3 matrix is associated with a corresponding 2x2 minor matrix, for which determinant is being calculated.
     *
     * @param array $matrix
     * @return array
     */
    static function findDeterminantForEach2x2MinorMatrixOf3x3Matrix(array $matrix) : array {
        $outcome = [];

        $outcome[0][0] = self::find2x2MatrixDeterminant( [ [$matrix[1][1], $matrix[1][2]], [$matrix[2][1], $matrix[2][2]] ] );
        $outcome[0][1] = self::find2x2MatrixDeterminant( [ [$matrix[1][0], $matrix[1][2]], [$matrix[2][0], $matrix[2][2]] ] );
        $outcome[0][2] = self::find2x2MatrixDeterminant( [ [$matrix[1][0], $matrix[1][1]], [$matrix[2][0], $matrix[2][1]] ] );

        $outcome[1][0] = self::find2x2MatrixDeterminant( [ [$matrix[0][1], $matrix[0][2]], [$matrix[2][1], $matrix[2][2]] ] );
        $outcome[1][1] = self::find2x2MatrixDeterminant( [ [$matrix[0][0], $matrix[0][2]], [$matrix[2][0], $matrix[2][2]] ] );
        $outcome[1][2] = self::find2x2MatrixDeterminant( [ [$matrix[0][0], $matrix[0][1]], [$matrix[2][0], $matrix[2][1]] ] );

        $outcome[2][0] = self::find2x2MatrixDeterminant( [ [$matrix[0][1], $matrix[0][2]], [$matrix[1][1], $matrix[1][2]] ] );
        $outcome[2][1] = self::find2x2MatrixDeterminant( [ [$matrix[0][0], $matrix[0][2]], [$matrix[1][0], $matrix[1][2]] ] );
        $outcome[2][2] = self::find2x2MatrixDeterminant( [ [$matrix[0][0], $matrix[0][1]], [$matrix[1][0], $matrix[1][1]] ] );

        return $outcome;
    }

    /**
     * Calculates determinant for 3x3 matrix.
     *
     * @param array $matrix
     * @return integer|float
     */
    static function findDeterminantOf3x3Matrix(array $matrix) {
        return 
            ($matrix[0][0] * ($matrix[1][1] * $matrix[2][2] - ($matrix[1][2] * $matrix[2][1]))) - 
            ($matrix[0][1] * ($matrix[1][0] * $matrix[2][2] - ($matrix[1][2] * $matrix[2][0]))) + 
            ($matrix[0][2] * ($matrix[1][0] * $matrix[2][1] - ($matrix[1][1] * $matrix[2][0])));
    }

    /**
     * Reverses signs of alternating terms in 3x3 matrix as cofactors.
     *
     * @param [type] $matrix
     * @return array
     */
    static function createMatrixOfCofactors($matrix) : array {
        return
            [
                [  $matrix[0][0], -$matrix[0][1],  $matrix[0][2] ],
                [ -$matrix[1][0],  $matrix[1][1], -$matrix[1][2] ],
                [  $matrix[2][0], -$matrix[2][1],  $matrix[2][2] ]
            ];
    }

    /**
     * Divides each term of matrix by the determinant.
     *
     * @param array $matrix 3x3 array.
     * @param integer|float $determinant
     * @return array
     */
    static function divide3x3MatrixByDeterminant(array $matrix, $determinant) : array {
        return
            [
                [ $matrix[0][0] / $determinant, $matrix[0][1] / $determinant, $matrix[0][2] / $determinant ],
                [ $matrix[1][0] / $determinant, $matrix[1][1] / $determinant, $matrix[1][2] / $determinant ],
                [ $matrix[2][0] / $determinant, $matrix[2][1] / $determinant, $matrix[2][2] / $determinant ]
            ];
    }

    /**
     * Matrix inversion formula.
     *
     * @param array $matrix
     * @return array
     */
    static function invert3x3Matrix(array $matrix) : array {
        $determinant = self::findDeterminantOf3x3Matrix($matrix);
        return 
            self::divide3x3MatrixByDeterminant(
                self::createMatrixOfCofactors( 
                    self::findDeterminantForEach2x2MinorMatrixOf3x3Matrix(
                        self::transpose3x3Matrix($matrix)
                    ) 
                ), 
                $determinant
        );
    }

    /**
     * Adaptation formula for XYZ, between source and reference white point and transformation method.
     *
     * @param array $XYZ Input XYZ values.
     * @param string|array $WP_s Source white point / standard illuminant tristimulus or proper name for standard illuminant.
     * @param string|array $WP_d Destination white point / standard illuminant tristimulus or proper name for standard illuminant.
     * @param array $M_tran Transformation matrix. By default uses Bradford BTM.
     * @return array Array with XYZ values.
     */
    static public function adapt(array $XYZ, $WP_s, $WP_d, array $M_tran = Matrices::Bradford) : array {
        $WP_s = Convert::_checkWhitePoint($WP_s); 
        $WP_d = Convert::_checkWhitePoint($WP_d);
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
        $outcome = 
        self::matrixVector( 
            self::matrices3x3Multiply( 
                self::matrices3x3Multiply( 
                    self::invert3x3Matrix( $M_tran ), 
                    $M_ADT ), 
                $M_tran ), 
            $XYZ );

        return [
            'X' => $outcome[0],
            'Y' => $outcome[1],
            'Z' => $outcome[2]
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
}
