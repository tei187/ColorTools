<?php

namespace tei187\ColorTools;

use tei187\ColorTools\StandardIlluminants\Tristimulus2;

/**
 * @link http://www.brucelindbloom.com/
 */
class Convert {
    //const EPSILON_INTENT = 0.00885645167903563081717167575546;
    const EPSILON = .008856;
    //const KAPPA_INTENT = 903.2962962962962962962962962963;
    const KAPPA = 903.3;
    const EPSILON_x_KAPPA = 7.9996248;

    /**
     * Converts data value from L\*C\*h to L\*a\*b.
     * 
     * @param array $data Array with 3 values corresponding to L, C, h.
     * @return array
     */
    public static function LCh_to_Lab(array $data) : array {
        list($L, $C, $h) = $data;

        return [
            'L' => $L,
            'a' => $C * cos(deg2rad($h)),
            'b' => $C * sin(deg2rad($h)),
        ];
    }

    public static function Lab_to_LCh(array $data) : array {
        list($L, $a, $b) = $data;
        $atan2 = rad2deg(atan2($b, $a));

        return [
            'L' => $L,
            'C' => sqrt(pow($a, 2) + pow($b, 2)),
            'h' => 
                ( $atan2 >= 0
                    ? $atan2
                    : $atan2 + 360
                )
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
            $L > self::EPSILON_x_KAPPA
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

    public static function XYZ_to_Luv(array $data, $whitepointTristimulus = Tristimulus2::D65) : array {
        list($X, $Y, $Z) = $data;
        list($X_r, $Y_r, $Z_r) = $whitepointTristimulus;

        $y_r = $Y / $Y_r;

        $u_p = (4 * $X) / ($X + (15*$Y) + (3*$Z));
        $v_p = (9 * $Y) / ($X + (15*$Y) + (3*$Z));

        $u_r_p = (4 * $X_r) / ($X_r + (15*$Y_r) + (3*$Z_r));
        $v_r_p = (9 * $Y_r) / ($X_r + (15*$Y_r) + (3*$Z_r));

        $L = 
            ( $y_r > self::EPSILON )
                ? 116 * sqrt(pow($y_r, 1/3))
                : self::KAPPA * $y_r;

        return [
            'L' => $L,
            'u' => 13 * $L * ($u_p - $u_r_p),
            'v' => 13 * $L * ($v_p - $v_r_p)
        ];
    }

    public function Luv_to_XYZ(array $data, $whitepointTristimulus = Tristimulus2::D65) : array {
        list($L, $u, $v) = $data;
        list($X_r, $Y_r, $Z_r) = $whitepointTristimulus;

        $u_0 = (4 * $X_r) / ($X_r + (15*$Y_r) + (3*$Z_r));
        $v_0 = (9 * $Y_r) / ($X_r + (15*$Y_r) + (3*$Z_r));

        $Y =
            $L > self::EPSILON_x_KAPPA
                ? pow(($L + 16) / 116, 3)
                : $L / self::KAPPA;

        $a = (1/3) * (((52 * $L) / ($u + (13 * $L * $u_0))) - 1);
        $b = -5 * $Y;
        $c = -1 / 3;
        $d = $Y * (((39 * $L) / ($v + (13*$L*$v_0))) - 5);

        $X = ($d - $b) / ($a - $c);

        return [
            'X' => $X,
            'Y' => $L > self::EPSILON_x_KAPPA ? pow(($L + 16) / 116, 3) : $L / self::KAPPA,
            'Z' => ($X * $a) + $b
        ];
    }

    public static function XYZ_to_LCh(array $data, $whitepointTristimulus = Tristimulus2::D65) : array {
        return self::Lab_to_LCh(self::XYZ_to_Lab($data, $whitepointTristimulus));
    }

    public static function LCh_to_XYZ(array $data, $whitepointTristimulus = Tristimulus2::D65) : array {
        return self::Lab_to_XYZ(self::LCh_to_Lab($data), $whitepointTristimulus);
    }

    public static function Lab_to_LUV(array $data, $whitepointTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_Luv(self::Lab_to_XYZ($data, $whitepointTristimulus), $whitepointTristimulus);
    }
    
    // https://cs.haifa.ac.il/hagit/courses/ist/Lectures/Demos/ColorApplet2/t_convert.html
    // http://www.russellcottrell.com/photo/matrixCalculator.htm
}
