<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Helpers\ArrayMethods;

/**
 * Trait handling conversion between chromaticity and tristimulus.
 * 
 * @see https://en.wikipedia.org/wiki/LMS_color_space
 * @see https://www.marcelpatek.com/color.html
 */
trait ConvertsBetweenXYandXYZ
{
  /**
   * Converts chromaticity coordinates (x, y) to tristimulus values (X, Y, Z).
   *
   * The tristimulus values represent the amounts of the three primary colors (red, green, blue) that are combined to match the given chromaticity coordinates.
   *
   * @param array $data An array containing the chromaticity coordinates (x, y).
   * @return array An array containing the tristimulus values (X, Y, Z).
   */
  static function chromaticity_to_tristimulus(array $data): array
  {
    list($x, $y) = ArrayMethods::makeList($data, 'xy');

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

  /**
   * Converts tristimulus values (X, Y, Z) to chromaticity coordinates (x, y).
   *
   * The chromaticity coordinates represent the proportions of the three primary colors (red, green, blue) that are combined to match the given tristimulus values.
   *
   * @param array $data An array containing the tristimulus values (X, Y, Z).
   * @return array An array containing the chromaticity coordinates (x, y).
   */
  static function tristimulus_to_chromaticity(array $data): array
  {
    list($X, $Y, $Z) = ArrayMethods::makeList($data, 'XYZ');

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
