<?php

namespace tei187\ColorTools\Conversion;

use tei187\ColorTools\StandardIlluminants\Tristimulus2;
use tei187\ColorTools\Traits\Tristimulus;
use tei187\ColorTools\Helpers\ArrayMethods;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Chromaticity\Adaptation\Adaptation;
use tei187\ColorTools\StandardIlluminants\Dictionary;

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
        list($L, $C, $h) = ArrayMethods::makeList($data, 'LCh');

        return [
            'L' => $L,
            'a' => $C * cos(deg2rad($h)),
            'b' => $C * sin(deg2rad($h)),
        ];
    }

    /**
     * Converts data value from L\*C\*h to Luv.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_Luv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_Luv( self::LCh_to_XYZ($data, $WP_RefTristimulus), $WP_RefTristimulus);
    }

    /**
     * Converts data value from L\*C\*h to xyY.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_xyY(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_xyY( self::LCh_to_XYZ($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from L\*C\*h to XYZ.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_XYZ(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::Lab_to_XYZ( self::LCh_to_Lab($data), $WP_RefTristimulus );
    }

    /**
     * Converts data value from L\*C\*h to LCh UV.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_LCh_uv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
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

    /**
     * Converts data value from L\*C\*h to RGB.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_RGB(array $data, $primaries = 'sRGB', array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_RGB(self::LCh_to_XYZ($data, $WP_RefTristimulus), $primaries, $WP_RefTristimulus);
    }

    /**
     * Converts data value from L\*C\*h to HSL.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_HSL(array $data, $primaries = 'sRGB', array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSL( self::LCh_to_RGB($data, $primaries, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from L\*C\*h to HSV.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_to_HSV(array $data, $primaries = 'sRGB', array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSV( self::LCh_to_RGB($data, $primaries, $WP_RefTristimulus) );
    }

// LCh UV
    /**
     * Converts data value from LCh UV to Luv.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @return array
     */
    public static function LCh_uv_to_Luv(array $data) {
        list($L, $C, $h) = ArrayMethods::makeList($data, 'LCh');

        return [
            'L' => $L,
            'u' => $C * cos(deg2rad($h)),
            'v' => $C * sin(deg2rad($h)),
        ];
    }

    /**
     * Converts data value from LCh UV to L\*C\*h.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_LCh(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return
            self::Lab_to_LCh( 
                self::LCh_uv_to_Lab($data, $WP_RefTristimulus) 
            );
    }

    /**
     * Converts data value from LCh UV to L\*a\*b.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_Lab(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return 
            self::XYZ_to_Lab( 
                self::Luv_to_XYZ( 
                    self::LCh_uv_to_Luv($data), 
                    $WP_RefTristimulus
                ), 
                $WP_RefTristimulus
            );
    }

    /**
     * Converts data value from LCh UV to XYZ.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_XYZ(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return
            self::Luv_to_XYZ(
                self::LCh_uv_to_Luv($data),
                $WP_RefTristimulus
            );
    }

    /**
     * Converts data value from LCh UV to xyY.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_xyY(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return
            self::XYZ_to_xyY(
                self::LCh_uv_to_XYZ($data, $WP_RefTristimulus)
            );
    }

    /**
     * Converts data value from LCh UV to RGB.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_RGB(array $data, $primaries = 'sRGB', array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_RGB(self::LCh_uv_to_XYZ($data, $WP_RefTristimulus), $primaries, $WP_RefTristimulus);
    }

    /**
     * Converts data value from L\*C\*h(uv) to HSL.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_HSL(array $data, $primaries = 'sRGB', array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSL(self::LCh_uv_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

    /**
     * Converts data value from L\*C\*h(uv) to HSV.
     *
     * @param array $data Array with 3 values corresponsding to L, C, h.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function LCh_uv_to_HSV(array $data, $primaries = 'sRGB', array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSV(self::LCh_uv_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

// Luv

    /**
     * Converts data value from Luv to XYZ.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_XYZ(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        list($L, $u, $v) = ArrayMethods::makeList($data, 'Luv');
        list($X_r, $Y_r, $Z_r) = ArrayMethods::makeList($WP_RefTristimulus, 'XYZ');

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

    /**
     * Converts data value from Luv to xyY.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_xyY(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_xyY( self::Luv_to_XYZ($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from Luv to LCh UV.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @return array
     */
    public static function Luv_to_LCh_uv(array $data) : array {
        list($L, $u, $v) = ArrayMethods::makeList($data, 'Luv');

        $atan = rad2deg(atan2($u, $v));

        return [
            'L' => $L,
            'C' => sqrt(pow($u, 2) + pow($v, 2)),
            'h' => $atan >= 0 ? $atan : $atan + 360
        ];
    }

    /**
     * Converts data value from Luv to L\*C\*h.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_LCh(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return
            self::XYZ_to_LCh(
                self::Luv_to_XYZ($data, $WP_RefTristimulus),
                $WP_RefTristimulus
            );
    }

    /**
     * Converts data value from Luv to L\*a\*b.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_Lab(array $data, $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return 
            self::XYZ_to_Lab(
                self::Luv_to_XYZ($data, $WP_RefTristimulus),
                $WP_RefTristimulus
            );
    }

    /**
     * Converts data value from Luv to RGB.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_RGB(array $data, $primaries = 'sRGB', $WP_RefTristimulus = Tristimulus2::D65) {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_RGB(self::Luv_to_XYZ($data, $WP_RefTristimulus), $primaries, $WP_RefTristimulus);
    }

    /**
     * Converts data value from Luv to HSL.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_HSL(array $data, $primaries = 'sRGB', $WP_RefTristimulus = Tristimulus2::D65) {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSL(self::Luv_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

    /**
     * Converts data value from Luv to HSV.
     *
     * @param array $data Array with 3 values corresponsding to L, u, v.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Luv_to_HSV(array $data, $primaries = 'sRGB', $WP_RefTristimulus = Tristimulus2::D65) {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSV(self::Luv_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

// Lab

    /**
     * Converts data value from L\*a\*b to xyY.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_xyY(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_xyY( self::Lab_to_XYZ($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from L\*a\*b to XYZ.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_XYZ(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        list($L, $a, $b) = ArrayMethods::makeList($data, 'Lab');
        list($X_r, $Y_r, $Z_r) = ArrayMethods::makeList($WP_RefTristimulus, 'XYZ');

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

    /**
     * Converts data value from L\*a\*b to L\*C\*h.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @return array
     */
    public static function Lab_to_LCh(array $data) : array {
        list($L, $a, $b) = ArrayMethods::makeList($data, 'Lab');
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

    /**
     * Converts data value from L\*a\*b to Luv.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_Luv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_Luv( self::Lab_to_XYZ($data, $WP_RefTristimulus), $WP_RefTristimulus );
    }

    /**
     * Converts data value from L\*a\*b to LCh UV.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_LCh_uv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        return self::Luv_to_LCh_uv( self::Lab_to_Luv($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from L\*a\*b to RGB.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_RGB(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_RGB(self::Lab_to_XYZ($data, $WP_RefTristimulus), $primaries, $WP_RefTristimulus);
    }

    /**
     * Converts data value from L\*a\*b to HSL.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_HSL(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSL(self::Lab_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

    /**
     * Converts data value from L\*a\*b to HSV.
     *
     * @param array $data Array with 3 values corresponsding to L, a, b.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function Lab_to_HSV(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSV(self::Lab_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

// xyY

    /**
     * Converts data value from xyY to XYZ.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_XYZ(array $data) : array {
        list($x, $y, $Y) = ArrayMethods::makeList($data, 'xyY');

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

    /**
     * Converts data value from xyY to L\*a\*b.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_Lab(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_Lab( self::xyY_to_XYZ($data), $WP_RefTristimulus );
    }

    /**
     * Converts data value from xyY to L\*C\*h.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_LCh(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::Lab_to_LCh( self::xyY_to_Lab($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from xyY to Luv.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_Luv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_Luv( self::xyY_to_XYZ($data), $WP_RefTristimulus );
    }

    /**
     * Converts data value from xyY to LCh UV.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_LCh_uv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::Luv_to_LCh_uv( self::xyY_to_Luv($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from xyY to RGB.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_RGB(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::XYZ_to_RGB(
            self::xyY_to_XYZ($data),
            $primaries,
            $WP_RefTristimulus
        );
    }

    /**
     * Converts data value from xyY to HSL.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_HSL(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSL(self::xyY_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

    /**
     * Converts data value from xyY to HSV.
     *
     * @param array $data Array with 3 values corresponsding to x, y, Y.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function xyY_to_HSV(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSV(self::xyY_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

// XYZ

    /**
     * Converts data value from XYZ to xyY.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @return array
     */
    public static function XYZ_to_xyY(array $data) : array {
        list($X, $Y, $Z) = ArrayMethods::makeList($data, 'XYZ');

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

    /**
     * Converts data value from XYZ to L\*a\*b.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_Lab(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        list($X, $Y, $Z) = ArrayMethods::makeList($data, 'XYZ');
        list($X_r, $Y_r, $Z_r) = ArrayMethods::makeList($WP_RefTristimulus, 'XYZ');

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

    /**
     * Converts data value from XYZ to Luv.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_Luv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        list($X, $Y, $Z) = ArrayMethods::makeList($data, 'XYZ');
        list($X_r, $Y_r, $Z_r) = ArrayMethods::makeList($WP_RefTristimulus, 'XYZ');

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

    /**
     * Converts data value from XYZ to L\*C\*h.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_LCh(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);

        return self::Lab_to_LCh( self::XYZ_to_Lab($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from XYZ to LCh UV.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_LCh_uv(array $data, array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);

        return self::Luv_to_LCh_uv( self::XYZ_to_Luv($data, $WP_RefTristimulus) );
    }

    /**
     * Converts data value from XYZ to RGB.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_RGB(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        
        if(is_object($primaries)) {
            if(!in_array("tei187\\ColorTools\\Interfaces\\Primaries", class_implements($primaries))) {
                return false;
            } else {
                $WP_RefTristimulus = self::_checkWhitePoint($primaries->getIlluminantTristimulus());
            }
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
            'R' => $primaries->applyCompanding($xyz_rgb[0], $primaries->getGamma()),
            'G' => $primaries->applyCompanding($xyz_rgb[1], $primaries->getGamma()),
            'B' => $primaries->applyCompanding($xyz_rgb[2], $primaries->getGamma())
        ];
    }

    /**
     * Converts data value from XYZ to HSL.
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_HSL(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSL(self::XYZ_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

    /**
     * Converts data value from XYZ to HSV
     *
     * @param array $data Array with 3 values corresponsding to X, Y, Z.
     * @param string $primaries RGB primaries through which the conversion will be applied. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @param array $WP_RefTristimulus Tristimulus of source/reference white point. D65 by default.
     * @return array
     */
    public static function XYZ_to_HSV(array $data, $primaries = 'sRGB', ?array $WP_RefTristimulus = Tristimulus2::D65) : array {
        $WP_RefTristimulus = self::_checkWhitePoint($WP_RefTristimulus);
        return self::RGB_to_HSV(self::XYZ_to_RGB($data, $primaries, $WP_RefTristimulus));
    }

// RGB

    /**
     * Converts data value from RGB to XYZ, given passed RGB primaries.
     * 
     * @param array $data Array with 3 values corresponsding to R, G, B.
     * @param object|string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @return array|false Array with keys 'values', 'illuminantName' and 'illuminantTristimulus' which correspond to XYZ values, and illuminant info of RGB primaries used.
     */
    public static function RGB_to_XYZ(array $data, $primaries = 'sRGB', $simple = true) {
        $primaries = self::_primariesResolver($primaries);

        $rgb_gamma = [];
        foreach($data as $value) {
            $rgb_gamma[] = $primaries->applyInverseCompanding(($value), $primaries->getGamma());
        }

        $primariesXYZ = [];
        foreach($primaries->getPrimariesXYY() as $values) {
            $primariesXYZ[] = array_values(Convert::xyY_to_XYZ($values));
        }

        if($simple) {
            return Adaptation::matrixVector(Adaptation::transpose3x3Matrix($primariesXYZ), $rgb_gamma);
        } else{
            return [
                'values' => Adaptation::matrixVector(Adaptation::transpose3x3Matrix($primariesXYZ), $rgb_gamma), 
                'illuminantName' => $primaries->getIlluminantName(),
                'illuminantTristimulus' => $primaries->getIlluminantTristimulus(),
            ];
        }
    }

    /**
     * Converts data value from RGB to xyY, given passed RGB primaries.
     * 
     * @param array $data Array with 3 values corresponsding to R, G, B.
     * @param object|string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @return array
     */
    public static function RGB_to_xyY(array $data, $primaries = 'sRGB') {
        return self::XYZ_to_xyY(
            self::RGB_to_XYZ($data, $primaries, false)['values']
        );
    }

    /**
     * Converts data value from RGB to L\*a\*b, given passed RGB primaries.
     * 
     * @param array $data Array with 3 values corresponsding to R, G, B.
     * @param object|string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @return array
     */
    public static function RGB_to_Lab(array $data, $primaries = 'sRGB') {
        $xyz = self::RGB_to_XYZ($data, $primaries, false);
        return self::XYZ_to_Lab($xyz['values'], $xyz['illuminantTristimulus']);
    }

    /**
     * Converts data value from RGB to L\*C\*h, given passed RGB primaries.
     * 
     * @param array $data Array with 3 values corresponsding to R, G, B.
     * @param object|string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @return array
     */
    public static function RGB_to_LCh(array $data, $primaries = 'sRGB') {
        $xyz = self::RGB_to_XYZ($data, $primaries, false);
        return self::Lab_to_LCh(self::XYZ_to_Lab($xyz['values'], $xyz['illuminantTristimulus']));
    }

    /**
     * Converts data value from RGB to Luv, given passed RGB primaries.
     * 
     * @param array $data Array with 3 values corresponsding to R, G, B.
     * @param object|string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @return array
     */
    public static function RGB_to_Luv(array $data, $primaries = 'sRGB') {
        $xyz = self::RGB_to_XYZ($data, $primaries, false);
        return self::XYZ_to_Luv($xyz['values'], $xyz['illuminantTristimulus']);
    }

    /**
     * Converts data value from RGB to LCh UV, given passed RGB primaries.
     * 
     * @param array $data Array with 3 values corresponsding to R, G, B.
     * @param object|string $primaries RGB primaries. Can be passed as object of RGBPrimaries namespace or defined class name. 'sRGB' by default.
     * @return array
     */
    public static function RGB_to_LCh_uv(array $data, $primaries = 'sRGB') {
        $xyz = self::RGB_to_XYZ($data, $primaries, false);
        return self::XYZ_to_LCh_uv($xyz['values'], $xyz['illuminantTristimulus']);
    }

    /**
     * Converts data value from RGB to HSL.
     *
     * @see https://www.had2know.org/technology/hsl-rgb-color-converter.html
     * 
     * @param array $data
     * @return array
     */
    public static function RGB_to_HSL(array $data) : array {
        list($R, $G, $B) = ArrayMethods::makeList($data, 'RGB');

        $M = max($data);
        $m = min($data);
        $d = ($M - $m);

        $L = (.5 * ($M + $m));

        $S = 
            $L > 0
                ? $d / (1 - abs((2*$L) - 1))
                : 0;


        return [
            'H' => 
                ( $G >= $B
                    ? rad2deg( acos( ($R - ($G/2) - ($B/2)) / sqrt(pow($R, 2) + pow($G, 2) + pow($B, 2) - ($R*$G) - ($R*$B) - ($G*$B) ) ) )
                    : 360 - rad2deg(acos( ($R - ($G/2) - ($B/2)) / sqrt(pow($R, 2) + pow($G, 2) + pow($B, 2) - ($R*$G) - ($R*$B) - ($G*$B) ) )) 
                ),
            'S' => $S,
            'L' => $L
        ];
    }

    /**
     * Converts data value from RGB to HSV.
     * 
     * @see https://www.had2know.org/technology/hsv-rgb-conversion-formula-calculator.html
     * 
     * @param array $data
     * @return array
     */
    public static function RGB_to_HSV(array $data) : array {
        list($R, $G, $B) = ArrayMethods::makeList($data, 'RGB');

        $M = max($data);
        $m = min($data);

        return [
            'H' => 
                ( $G >= $B
                    ? rad2deg( acos( ($R - ($G/2) - ($B/2)) / sqrt(pow($R, 2) + pow($G, 2) + pow($B, 2) - ($R*$G) - ($R*$B) - ($G*$B) ) ) )
                    : 360 - rad2deg(acos( ($R - ($G/2) - ($B/2)) / sqrt(pow($R, 2) + pow($G, 2) + pow($B, 2) - ($R*$G) - ($R*$B) - ($G*$B) ) )) 
                ),
            'S' =>
                (
                    $M > 0
                        ? 1 - ($m/$M)
                        : 0
                ), 
            'V' => $M
        ];
    }

// HSL

    /**
     * Converts data value from HSL to RGB.
     *
     * @see https://www.had2know.org/technology/hsl-rgb-color-converter.html
     * 
     * @param array $data
     * @return array
     */
    public static function HSL_to_RGB(array $data) : array {
        list($H, $S, $L) = ArrayMethods::makeList($data, 'HSL');

        $d = $S * (1 - abs((2*$L)-1));
        $m = ($L - ($d / 2));

        $x = $d * (1 - abs(fmod(($H / 60),2) - 1));

        if($H >= 0 && $H < 60) {
            return [
                'R' => ($d) + $m,
                'G' => ($x) + $m,
                'B' => $x
            ];
        } elseif($H >= 60 && $H < 120) {
            return [
                'R' => ($x) + $m,
                'G' => ($d) + $m,
                'B' => $x
            ];
        } elseif($H >= 120 && $H < 180) {
            return [
                'R' => $m,
                'G' => ($d) + $m,
                'B' => ($x) + $m
            ];
        } elseif($H >= 180 && $H < 240) {
            return [
                'R' => $m,
                'G' => ($x) + $m,
                'B' => ($d) + $m
            ];
        } elseif($H >= 240 && $H < 300) {
            return [
                'R' => ($x) + $m,
                'G' => $m,
                'B' => ($d) + $m
            ];
        } else {
            return [
                'R' => ($d) + $m,
                'G' => $m,
                'B' => ($x) + $m
            ];
        }
    }

    /**
     * Converts data value from HSL to LCh(uv), through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSL_to_LCh_uv(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_LCh_uv(self::HSL_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSL to LCh(ab), through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSL_to_LCh(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_LCh(self::HSL_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSL to Luv, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSL_to_Luv(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_Luv(self::HSL_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSL to L\*a\*b, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSL_to_Lab(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_Lab(self::HSL_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSL to XYZ, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSL_to_XYZ(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_XYZ(self::HSL_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSL to xyY, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSL_to_xyY(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_xyY(self::HSL_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSL to HSV.
     *
     * @param array $data 
     * @return array
     */
    public static function HSL_to_HSV(array $data) : array {
        list($H, $S, $L) = ArrayMethods::makeList($data, 'HSL');

        $V = $L + ($S * min($L, 1 - $L));

        return [
            'H' => $H,
            'S' => ( $V == 0 ? 0 : 2 * (1 - ($L / $V)) ),
            'V' => $V
        ];
    }


/// HSV

    /**
     * Converts data value from HSV to RGB.
     * 
     * @see https://www.had2know.org/technology/hsv-rgb-conversion-formula-calculator.html
     * 
     * @param array $data
     * @return array
     */
    public static function HSV_to_RGB(array $data) : array {
        list($H, $S, $V) = ArrayMethods::makeList($data, 'HSV');

        $M = $V;
        $m = $M * (1 - $S);
        $z = ($M - $m) * (1 - abs(fmod($H/60, 2) - 1));

        if($H >= 0 && $H < 60) {
            return [
                'R' => $M,
                'G' => $z + $m,
                'B' => $m
            ];
        } elseif($H >= 60 && $H < 120) {
            return [
                'R' => $z + $m,
                'G' => $M,
                'B' => $m
            ];
        } elseif($H >= 120 && $H < 180) {
            return [
                'R' => $m,
                'G' => $M,
                'B' => $z + $m
            ];
        } elseif($H >= 180 && $H < 240) {
            return [
                'R' => $m,
                'G' => $z + $m,
                'B' => $M
            ];
        } elseif($H >= 240 && $H < 300) {
            return [
                'R' => $z + $m,
                'G' => $m,
                'B' => $M
            ];
        } else {
            return [
                'R' => $M,
                'G' => $m,
                'B' => $z + $m
            ];
        }
    }

    public static function HSV_to_HSL(array $data) : array {
        list($H, $S, $V) = ArrayMethods::makeList($data, 'HSV');

        $L = $V * (1 - ($S / 2));

        return [
            'H' => $H,
            'S' => ( $L == 0 || $L == 1 ? 0 : ($V - 1) / min($L, 1 - $L) ),
            'L' => $L
        ];
    }

    /**
     * Converts data value from HSV to L\*a\*b, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSV_to_Lab(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_Lab(self::HSV_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSV to LCh(ab), through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSV_to_LCh(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_LCh(self::HSV_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSV to LCh(uv), through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSV_to_LCh_uv(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_LCh_uv(self::HSV_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSV to Luv, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSV_to_Luv(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_Luv(self::HSV_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSV to xyY, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSV_to_xyY(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_xyY(self::HSV_to_RGB($data), $primaries);
    }

    /**
     * Converts data value from HSV to XYZ, through RGB.
     *
     * @param array $data 
     * @param string $primaries Selected RGB primaries, by default sRGB.
     * @return array
     */
    public static function HSV_to_XYZ(array $data, $primaries = 'sRGB') : array {
        return self::RGB_to_XYZ(self::HSV_to_RGB($data), $primaries);
    }

    // xy Chromaticity

    public static function xy_to_XYZ(array $data) : array {
        return self::chromaticity_to_tristimulus($data);
    }

    public static function XYZ_to_xy(array $data) : array {
        return self::tristimulus_to_chromaticity($data);
    }

    /**
     * Resolves RGBprimaries per input. If input cannot be associated with any defined, returns RGB.
     *
     * @param object|string $primaries Typically an object of RGBPrimaries namespace or name 
     * @return object
     */
    private static function _primariesResolver($primaries) {
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
        return $primaries;
    }
    
    /**
     * Checks specified whitepoint for validity.
     * 
     * If array is passed as `$var`, will check if tristimulus or chromaticity values are passed. If later, will convert to tristimulus.
     * If string is passed as `$var`, will check if a standard illuminant name is used. In this case, there is a possiblity to use a separator `|`, after which standard observer angle can be passed. If there is none, assumes 2 degree angle observer.
     *
     * @param array|string $var
     * @return array|false Returns a tristimulus array. Will return boolean `false` if a string was passed as argument and cannot be assesed as a standard illuminant white point.
     */
    public static function _checkWhitePoint($var) {
        if(is_string($var)) {
            // check string
            $check = Dictionary::assessStandardIlluminant($var);
            if($check === false) {
                return false;
            } else {
                $var = explode("|", $var);
                $angle = isset($var[1]) && in_array($var[1], [2, 10])
                    ? $var[1]
                    : 2;
                if(strpos($var[0], 'LED') !== false) {
                    $angle = 2;
                }                
                return constant("\\tei187\\ColorTools\\StandardIlluminants\\Tristimulus".$angle."::".strtoupper(trim($var[0])));
            }
        } elseif(is_array($var)) {
            $length = count($var); 
            if($length == 3) {
                // assume XYZ
                return
                    ArrayMethods::checkForKeys($var, 'XYZ') === false
                        ? false
                        : array_values($var);
            } elseif($length == 2) {
                // assume xy
                return
                    ArrayMethods::checkForKeys($var, 'xy') === false
                        ? false
                        : self::xy_to_XYZ($var);
            }
        }
        return false;
    }

    // https://cs.haifa.ac.il/hagit/courses/ist/Lectures/Demos/ColorApplet2/t_convert.html
    // http://www.russellcottrell.com/photo/matrixCalculator.htm

    // https://fujiwaratko.sakura.ne.jp/infosci/colorspace/rgb_xyz_e.html
    // https://fujiwaratko.sakura.ne.jp/infosci/colorspace/colorspace2_e.html
}
