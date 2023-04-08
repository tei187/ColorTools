<?php

namespace tei187\ColorTools\Conversion;

use tei187\ColorTools\StandardIlluminants\Tristimulus2;
use tei187\ColorTools\Traits\Tristimulus;
use tei187\ColorTools\Helpers\CheckArray;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Chromaticity\Adaptation\Adaptation;

/**
 * Color equations and conversions based on Bruce Lindbloom's website information.
 * 
 * **IMPORTANT:** Whenever reference white point tristimulus is required, by default the values correspond to D65 illuminant based on 2 degrees Standard Observer reference.
 * - If no illuminant change is required, use the one with which the measurement was done.
 * - If illuminant is to be changed (between reference and target), use :php:method:`tei187\ColorTools\Chromaticity\Adaptation\Adaptation::adapt()` method on the input values first, and proceed with using the target white point further on.
 * 
 * @see http://www.brucelindbloom.com/
 */
class Convert {
    use Tristimulus,
        PrimariesLoader;

    //const EPSILON_INTENT = 0.00885645167903563081717167575546;
    const EPSILON = .008856;
    //const KAPPA_INTENT = 903.2962962962962962962962962963;
    const KAPPA = 903.3;
    //const EPSILON_x_KAPPA_INTENT = 7.999999999999971;
    const EPSILON_x_KAPPA = 7.9996248;

// LCh

    /**
     * Converts data value from L\*C\*h to L\*a\*b.
     * 
     * @param array $data Array with 3 values corresponding to L, C, h.
     * @return array
     */
    public static function LCh_to_Lab(array $data) : array {
        list($L, $C, $h) = CheckArray::makeList($data, 'LCh');

        return [
            'L' => $L,
            'a' => $C * cos(deg2rad($h)),
            'b' => $C * sin(deg2rad($h)),
        ];
    }

    public static function LCh_to_Luv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_Luv( self::LCh_to_XYZ($data, $WP_RefTristimulus), $WP_RefTristimulus);
    }

    public static function LCh_to_xyY(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_xyY( self::LCh_to_XYZ($data, $WP_RefTristimulus) );
    }

    public static function LCh_to_XYZ(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Lab_to_XYZ( self::LCh_to_Lab($data), $WP_RefTristimulus );
    }

    public static function LCh_to_LCh_uv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return 
            self::Luv_to_LCh_uv( 
                self::XYZ_to_Luv( 
                    self::Lab_to_XYZ( 
                        self::LCh_to_Lab($data), 
                        $WP_RefTristimulus 
                    ), 
                    $WP_RefTristimulus
                ) 
            );
    }

// LCh UV
    public static function LCh_uv_to_Luv(array $data) {
        list($L, $C, $h) = CheckArray::makeList($data, 'LCh');

        return [
            'L' => $L,
            'u' => $C * cos(deg2rad($h)),
            'v' => $C * sin(deg2rad($h)),
        ];
    }

    public static function LCh_uv_to_LCh(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return
            self::Lab_to_LCh( 
                self::LCh_uv_to_Lab($data, $WP_RefTristimulus) 
            );
    }

    public static function LCh_uv_to_Lab(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return 
            self::XYZ_to_Lab( 
                self::Luv_to_XYZ( 
                    self::LCh_uv_to_Luv($data), 
                    $WP_RefTristimulus
                ), 
                $WP_RefTristimulus
            );
    }

    public static function LCh_uv_to_XYZ(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return
            self::Luv_to_XYZ(
                self::LCh_uv_to_Luv($data),
                $WP_RefTristimulus
            );
    }

    public static function LCh_uv_to_xyY(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return
            self::XYZ_to_xyY(
                self::LCh_uv_to_XYZ($data, $WP_RefTristimulus)
            );
    }

// Luv

    public static function Luv_to_XYZ(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        list($L, $u, $v) = CheckArray::makeList($data, 'Luv');
        list($X_r, $Y_r, $Z_r) = CheckArray::makeList($WP_RefTristimulus, 'XYZ');

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

    public static function Luv_to_xyY(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_xyY( self::Luv_to_XYZ($data, $WP_RefTristimulus) );
    }

    public static function Luv_to_LCh_uv(array $data) : array {
        list($L, $u, $v) = CheckArray::makeList($data, 'Luv');

        $atan = rad2deg(atan2($u, $v));

        return [
            'L' => $L,
            'C' => sqrt(pow($u, 2) + pow($v, 2)),
            'h' => $atan >= 0 ? $atan : $atan + 360
        ];
    }

    public static function Luv_to_LCh(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return
            self::XYZ_to_LCh(
                self::Luv_to_XYZ($data, $WP_RefTristimulus),
                $WP_RefTristimulus
            );
    }

    public static function Luv_to_Lab(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return 
            self::XYZ_to_Lab(
                self::Luv_to_XYZ($data, $WP_RefTristimulus),
                $WP_RefTristimulus
            );
    }

// Lab

    public static function Lab_to_xyY(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_xyY( self::Lab_to_XYZ($data, $WP_RefTristimulus) );
    }

    public static function Lab_to_XYZ(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        list($L, $a, $b) = CheckArray::makeList($data, 'Lab');
        list($X_r, $Y_r, $Z_r) = CheckArray::makeList($WP_RefTristimulus, 'XYZ');

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

    public static function Lab_to_LCh(array $data) : array {
        list($L, $a, $b) = CheckArray::makeList($data, 'Lab');
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

    public static function Lab_to_Luv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_Luv( self::Lab_to_XYZ($data, $WP_RefTristimulus), $WP_RefTristimulus );
    }

    public static function Lab_to_LCh_uv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Luv_to_LCh_uv( self::Lab_to_Luv($data, $WP_RefTristimulus) );
    }

// xyY

    public static function xyY_to_XYZ(array $data) : array {
        list($x, $y, $Y) = CheckArray::makeList($data, 'xyY');

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

    public static function xyY_to_Lab(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_Lab( self::xyY_to_XYZ($data), $WP_RefTristimulus );
    }

    public static function xyY_to_LCh(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Lab_to_LCh( self::xyY_to_Lab($data, $WP_RefTristimulus) );
    }

    public static function xyY_to_Luv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::XYZ_to_Luv( self::xyY_to_XYZ($data), $WP_RefTristimulus );
    }

    public static function xyY_to_LCh_uv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Luv_to_LCh_uv( self::xyY_to_Luv($data, $WP_RefTristimulus) );
    }

// XYZ


    public static function XYZ_to_xyY(array $data) : array {
        list($X, $Y, $Z) = CheckArray::makeList($data, 'XYZ');

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

    public static function XYZ_to_Lab(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        list($X, $Y, $Z) = CheckArray::makeList($data, 'XYZ');
        list($X_r, $Y_r, $Z_r) = CheckArray::makeList($WP_RefTristimulus, 'XYZ');

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

    public static function XYZ_to_Luv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        list($X, $Y, $Z) = CheckArray::makeList($data, 'XYZ');
        list($X_r, $Y_r, $Z_r) = CheckArray::makeList($WP_RefTristimulus, 'XYZ');

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

    public static function XYZ_to_LCh(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Lab_to_LCh( self::XYZ_to_Lab($data, $WP_RefTristimulus) );
    }

    public static function XYZ_to_LCh_uv(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Luv_to_LCh_uv( self::XYZ_to_Luv($data, $WP_RefTristimulus) );
    }

    public static function XYZ_to_RGB(array $data, $primaries, ?array $WP_RefTristimulus = Tristimulus2::D65) {
        if(is_object($primaries) && !in_array("tei187\\ColorTools\\Interfaces\\Primaries", class_implements($primaries))) {
            return false;
        }
        if(is_string($primaries)) {
            $primaries = self::loadPrimaries($primaries);
            if($primaries === false) {
                return false;
            }
        }

        $primariesXYZ = [];
        if($WP_RefTristimulus !== null) {
            foreach($primaries->getPrimariesXYY() as $values) {
                $primariesXYZ[] = array_values(
                    Adaptation::adapt(
                        Convert::xyY_to_XYZ($values), 
                        $primaries->getIlluminantTristimulus(), 
                        $WP_RefTristimulus));
            }
        } else {
            foreach($primaries->getPrimariesXYY() as $values) {
                $primariesXYZ[] = array_values(Convert::xyY_to_XYZ($values));
            }
        }
        
        $matrix = Adaptation::transpose3x3Matrix( Adaptation::invert3x3Matrix($primariesXYZ) );
        $xyz_rgb = Adaptation::matrixVector($matrix, array_values($data));

        return [
            'R' => round( $primaries->applyCompanding($xyz_rgb[0], $primaries->getGamma()) * 255 ),
            'G' => round( $primaries->applyCompanding($xyz_rgb[1], $primaries->getGamma()) * 255 ),
            'B' => round( $primaries->applyCompanding($xyz_rgb[2], $primaries->getGamma()) * 255 )
        ];
    }

// RGB

    /**
     * Returns array or false
     * 
     * @param array $data
     * @param object|string $primaries
     * @return array|false Array with keys 'values', 'illuminantName' and 'illuminantTristimulus' which correspond to XYZ values, and illuminant info of RGB primaries used.
     */
    public static function RGB_to_XYZ(array $data, $primaries) {
        if(is_object($primaries) && !self::_verifyPrimariesObject($primaries)) {
            return false;
        } elseif(is_string($primaries)) {
            $loader = self::loadPrimaries($primaries);
            if($loader === false) {
                return false;
            }
            $primaries = $loader;
            unset($loader);
        } else {
            $primaries = self::loadPrimaries('sRGB');
        }

        $rgb_gamma = [];
        foreach($data as $value) {
            $rgb_gamma[] = $primaries->applyInverseCompanding(($value / 255), $primaries->getGamma());
        }

        $primariesXYZ = [];
        foreach($primaries->getPrimariesXYY() as $values) {
            $primariesXYZ[] = array_values(Convert::xyY_to_XYZ($values));
        }

        return [
            'values' => Adaptation::matrixVector(Adaptation::transpose3x3Matrix($primariesXYZ), $rgb_gamma), 
            'illuminantName' => $primaries->getIlluminantName(),
            'illuminantTristimulus' => $primaries->getIlluminantTristimulus(),
        ];
    }

    public static function RGB_to_xyY(array $data, $primaries) {
        return self::XYZ_to_xyY(self::RGB_to_XYZ($data, $primaries)['values']);
    }

    public static function RGB_to_Lab(array $data, $primaries) {
        $xyz = self::RGB_to_XYZ($data, $primaries);
        return self::XYZ_to_Lab($xyz['values'], $xyz['illuminantTristimulus']);
    }

    public static function RGB_to_LCh(array $data, $primaries) {
        $xyz = self::RGB_to_XYZ($data, $primaries);
        return self::Lab_to_LCh(self::XYZ_to_Lab($xyz['values'], $xyz['illuminantTristimulus']));
    }

    public static function RGB_to_Luv(array $data, $primaries) {
        $xyz = self::RGB_to_XYZ($data, $primaries);
        return self::XYZ_to_Luv($xyz['values'], $xyz['illuminantTristimulus']);
    }

    public static function RGB_to_LCh_uv(array $data, $primaries) {
        $xyz = self::RGB_to_XYZ($data, $primaries);
        return self::XYZ_to_LCh_uv($xyz['values'], $xyz['illuminantTristimulus']);
    }

    // xy Chromaticity

    public static function xy_to_XYZ(array $data) : array {
        return self::chromaticity_to_tristimulus($data);
    }

    public static function XYZ_to_xy(array $data) : array {
        return self::tristimulus_to_chromaticity($data);
    }
    
    // https://cs.haifa.ac.il/hagit/courses/ist/Lectures/Demos/ColorApplet2/t_convert.html
    // http://www.russellcottrell.com/photo/matrixCalculator.htm

    // https://fujiwaratko.sakura.ne.jp/infosci/colorspace/rgb_xyz_e.html
    // https://fujiwaratko.sakura.ne.jp/infosci/colorspace/colorspace2_e.html
}
