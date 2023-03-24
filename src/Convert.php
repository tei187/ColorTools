<?php

namespace tei187\ColorTools;

use tei187\ColorTools\StandardIlluminants\Tristimulus2;

class Convert {
    const EPSILON_INTENT = 0.00885645167903563081717167575546;
    const EPSILON = .008856;
    const KAPPA_INTENT = 903.2962962962962962962962962963;
    const KAPPA = 903.3;

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

    public static function xy_to_XYZ(array $data) : array {
        list($x, $y) = $data;
        return $y == 0
            ? [
                'X' => 0,
                'Y' => 0,
                'Z' => 0
              ]
            : [
                'X' => $x / $y,
                'Y' => 1,
                'Z' => (1 - $x - $y) / $y
              ];
    }

    public static function XYZ_to_xy(array $data) : array {
        list($X, $Y, $Z) = $data;
        return $X + $Y + $Z == 0
            ? [ 
                'x' => 0, 
                'y' => 0
              ]
            : [ 'x' => $X / ($X + $Y + $Z),
                'y' => $Y / ($X + $Y + $Z)
              ];
    }

    public static function xyY_to_XYZ(array $data) : array {
        list($x, $y, $Y) = $data;
        return $y == 0
            ? [
                'X' => 0,
                'Y' => 0,
                'Z' => 0
              ]
            : [
                'X' => ($x * $Y) / $y,
                'Y' => $Y,
                'Z' => ((1 - $x - $y) * $Y ) / $y
              ];
    }

    public static function XYZ_to_xyY(array $data) : array {
        list($X, $Y, $Z) = $data;
        return $X + $Y + $Z == 0
            ? [
                'x' => 0,
                'y' => 0,
                'Y' => 0
              ]
            : [
                'x' => $X / ($X + $Y + $Z),
                'y' => $Y / ($X + $Y + $Z),
                'Y' => $Y
            ];
    }

    public static function XYZ_to_Lab(array $data, array $whitepointTristimulus = Tristimulus2::D65) : array {
        list($X, $Y, $Z) = $data;
        list($X_r, $Y_r, $Z_r) = $whitepointTristimulus;

        $x_r = $X / $X_r;
        $y_r = $Y / $Y_r;
        $z_r = $Z / $Z_r;


        $f_x =
            $x_r > self::EPSILON
                ? pow($x_r, 1/3)
                : ((self::EPSILON  * $x_r) + 16) / 116;
        $f_y =
            $y_r > self::EPSILON
                ? pow($y_r, 1/3)
                : ((self::EPSILON  * $y_r) + 16) / 116;
        $f_z =
            $z_r > self::EPSILON
                ? pow($z_r, 1/3)
                : ((self::EPSILON  * $z_r) + 16) / 116;
        
        return [
            'L' => (116 * $f_y) - 16,
            'a' => 500 * ($f_x - $f_y),
            'b' => 200 * ($f_y - $f_z)
        ];
    }

    public static function Lab_to_XYZ(array $data, array $whitepointTristimulus = Tristimulus2::D65) : array {
        list($L, $a, $b) = $data;
        list($X_r, $Y_r, $Z_r) = $whitepointTristimulus;

        $f_y = ($L + 16) / 116;
        $f_x = ($a / 500) + $f_y;
        $f_z = $f_y - ($b / 200);

        $x_r =
            pow($f_x, 3) > self::EPSILON
                ? pow($f_x, 3)
                : ((116 * $f_x) - 16) / self::KAPPA;
        $y_r =
            $L > self::KAPPA * self::EPSILON
                ? pow(($L + 16) / 116, 3)
                : $L / self::KAPPA;
        $z_r =
            pow($f_z, 3) > self::EPSILON
                ? pow($f_z, 3)
                : ((116 * $f_z) - 16) / self::KAPPA;
        return [
            'X' => $x_r * $X_r,
            'Y' => $y_r * $Y_r,
            'Z' => $z_r * $Z_r
        ];
    }

    

    // https://cs.haifa.ac.il/hagit/courses/ist/Lectures/Demos/ColorApplet2/t_convert.html
    // http://www.russellcottrell.com/photo/matrixCalculator.htm
}
