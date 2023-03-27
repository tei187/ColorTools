<?php

namespace tei187\ColorTools\Traits;

/**
 * Trait handling conversion between chromaticity and tristimulus.
 * 
 * @see https://en.wikipedia.org/wiki/LMS_color_space
 * @see https://www.marcelpatek.com/color.html
 */
Trait Tristimulus {
    static function chromaticity_to_tristimulus(array $data) : array {
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

    static function tristimulus_to_chromaticity(array $data) {
        list($X, $Y, $Z) = $data;

        return $X + $Y + $Z == 0
            ? [
                'x' => 0,
                'y' => 0
              ]
            : [
                'x' => $X / ($X + $Y + $Z),
                'y' => $Y / ($X + $Y + $Z)
              ];
    }
}
