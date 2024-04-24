<?php

namespace tei187\ColorTools\Math\Chromaticity;

use tei187\ColorTools\Dictionaries\CAT\Matrices;
use tei187\ColorTools\Math\ModelConversion;

/**
 * Chromatic adaptation handler.
 * 
 * @see https://www.xrite.com/en/service-support/chromaticadaptationwhatisitwhatdoesitdo
 * @see http://www.russellcottrell.com/photo/matrixCalculator.htm
 * @see https://www.wikihow.com/Find-the-Inverse-of-a-3x3-Matrix Math based on article.
 */
class Adaptation {
    /**
     * Multiplies a 3x3 matrix by a 1x3 vector and returns the resulting 3-element vector.
     *
     * @param array $matrix A 3x3 matrix represented as an array of 3 arrays, each containing 3 elements.
     * @param array $vector A 3-element vector represented as an array (treated as column).
     * @return array The resulting 3-element vector.
     */
    static function matrixVector(array $matrix, array $vector): array
    {
        $output = [];

        $temp = [];
        foreach ($matrix as $row) {
            $temp[] = array_values($row);
        };
        $matrix = $temp;
        unset($temp, $row);

        $vector = array_values($vector);

        for ($i = 0; $i <= 2; $i++) {
            $sum = 0;
            for ($j = 0; $j <= 2; $j++) {
                $sum += $matrix[$i][$j] * $vector[$j];
            }
            $output[$i] = $sum;
        }

        return $output;
    }
    
    /**
     * Transposes a 3x3 matrix.
     *
     * @param array $matrix The 3x3 matrix to transpose.
     * @return array The transposed 3x3 matrix.
     */
    static function transpose3x3Matrix(array $matrix): array
    {
        return [
            [$matrix[0][0], $matrix[1][0], $matrix[2][0]],
            [$matrix[0][1], $matrix[1][1], $matrix[2][1]],
            [$matrix[0][2], $matrix[1][2], $matrix[2][2]]
        ];
    }

    /**
     * Calculates the determinant of a 2x2 matrix.
     *
     * @param array $matrix A 2x2 matrix represented as a nested array.
     * @return float The determinant of the input matrix.
     */
    static function find2x2MatrixDeterminant(array $matrix)
    {
        return $matrix[0][0] * $matrix[1][1] - ($matrix[0][1] * $matrix[1][0]);
    }

    /**
     * Calculates the determinants of all 2x2 minor matrices of a 3x3 matrix.
     *
     * This function takes a 3x3 matrix as input and calculates the determinants of all
     * the 2x2 minor matrices that can be formed from the 3x3 matrix. The resulting
     * determinants are returned in a 3x3 array.
     *
     * @param array $matrix The 3x3 matrix to calculate the 2x2 minor matrix determinants for.
     * @return array The 3x3 array of 2x2 minor matrix determinants.
     */
    static function findDeterminantForEach2x2MinorMatrixOf3x3Matrix(array $matrix): array
    {
        $outcome = [];

        $outcome[0][0] = self::find2x2MatrixDeterminant([[$matrix[1][1], $matrix[1][2]], [$matrix[2][1], $matrix[2][2]]]);
        $outcome[0][1] = self::find2x2MatrixDeterminant([[$matrix[1][0], $matrix[1][2]], [$matrix[2][0], $matrix[2][2]]]);
        $outcome[0][2] = self::find2x2MatrixDeterminant([[$matrix[1][0], $matrix[1][1]], [$matrix[2][0], $matrix[2][1]]]);

        $outcome[1][0] = self::find2x2MatrixDeterminant([[$matrix[0][1], $matrix[0][2]], [$matrix[2][1], $matrix[2][2]]]);
        $outcome[1][1] = self::find2x2MatrixDeterminant([[$matrix[0][0], $matrix[0][2]], [$matrix[2][0], $matrix[2][2]]]);
        $outcome[1][2] = self::find2x2MatrixDeterminant([[$matrix[0][0], $matrix[0][1]], [$matrix[2][0], $matrix[2][1]]]);

        $outcome[2][0] = self::find2x2MatrixDeterminant([[$matrix[0][1], $matrix[0][2]], [$matrix[1][1], $matrix[1][2]]]);
        $outcome[2][1] = self::find2x2MatrixDeterminant([[$matrix[0][0], $matrix[0][2]], [$matrix[1][0], $matrix[1][2]]]);
        $outcome[2][2] = self::find2x2MatrixDeterminant([[$matrix[0][0], $matrix[0][1]], [$matrix[1][0], $matrix[1][1]]]);

        return $outcome;
    }

    /**
     * Calculates the determinant of a 3x3 matrix.
     *
     * @param array $matrix A 3x3 matrix represented as a nested array.
     * @return float The determinant of the input matrix.
     */
    static function findDeterminantOf3x3Matrix(array $matrix)
    {
        return 
             ($matrix[0][0] * ($matrix[1][1] * $matrix[2][2] - ($matrix[1][2] * $matrix[2][1])))
           - ($matrix[0][1] * ($matrix[1][0] * $matrix[2][2] - ($matrix[1][2] * $matrix[2][0])))
           + ($matrix[0][2] * ($matrix[1][0] * $matrix[2][1] - ($matrix[1][1] * $matrix[2][0])));
    }

    /**
     * Creates a matrix of cofactors from the given 3x3 matrix.
     *
     * Reverses signs of alternating terms in 3x3 matrix as cofactors. The cofactor of an element in a matrix is the determinant of the submatrix formed by deleting the row and column containing that element, multiplied by (-1)^(i+j), where i and j are the row and column indices of the element.
     *
     * @param array $matrix The input 3x3 matrix.
     * @return array The matrix of cofactors.
     */
    static function createMatrixOfCofactors($matrix): array
    {
        return 
        [
            [ $matrix[0][0], -$matrix[0][1],  $matrix[0][2]],
            [-$matrix[1][0],  $matrix[1][1], -$matrix[1][2]],
            [ $matrix[2][0], -$matrix[2][1],  $matrix[2][2]]
        ];
    }

    /**
     * Divides a 3x3 matrix by a determinant.
     *
     * @param array $matrix The 3x3 matrix to divide.
     * @param float $determinant The determinant to divide the matrix by.
     * @return array The resulting 3x3 matrix after division.
     */
    static function divide3x3MatrixByDeterminant(array $matrix, $determinant): array
    {
        return
        [
            [$matrix[0][0] / $determinant, $matrix[0][1] / $determinant, $matrix[0][2] / $determinant],
            [$matrix[1][0] / $determinant, $matrix[1][1] / $determinant, $matrix[1][2] / $determinant],
            [$matrix[2][0] / $determinant, $matrix[2][1] / $determinant, $matrix[2][2] / $determinant]
        ];
    }

    /**
     * Inverts a 3x3 matrix.
     *
     * @param array $matrix The 3x3 matrix to invert.
     * @return array The inverted 3x3 matrix.
     */
    static function invert3x3Matrix(array $matrix): array
    {
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
     * Adapts the given XYZ color values from one white point to another using the selected chromatic adaptation transform (by default Bradford BTM).
     *
     * @param array $XYZ The input XYZ color values to adapt.
     * @param array $WP_s The source white point / standard illuminant tristimulus or proper name for standard illuminant
     * @param array $WP_d The destination white point / standard illuminant tristimulus or proper name for standard illuminant.
     * @param array $M_tran The chromatic adaptation transform matrix, defaults to the Bradford matrix.
     * @return array The adapted XYZ color values.
     */
    static public function adapt(array $XYZ, $WP_s, $WP_d, array $M_tran = Matrices::Bradford): array
    {
        $WP_s = ModelConversion::_checkWhitePoint($WP_s);
        $WP_d = ModelConversion::_checkWhitePoint($WP_d);
        
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
                        self::invert3x3Matrix($M_tran), 
                        $M_ADT
                    ),
                    $M_tran
                ),
                $XYZ
            );

        return [
            'X' => $outcome[0],
            'Y' => $outcome[1],
            'Z' => $outcome[2]
        ];
    }

    /**
     * Multiplies two 3x3 matrices and returns the result.
     *
     * @param array $m1 The first 3x3 matrix.
     * @param array $m2 The second 3x3 matrix.
     * @return array The result of multiplying the two matrices.
     */
    static function matrices3x3Multiply(array $m1, array $m2): array
    {
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
