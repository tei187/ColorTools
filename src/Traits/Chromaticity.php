<?php

namespace tei187\ColorTools\Traits;

Trait Chromaticity {
    /**
     * @link https://engineering.purdue.edu/~bouman/ece637/notes/pdf/ColorSpaces.pdf
     * @param array $xy
     * @return float
     */
    static function calculateZfromXY(array $xy) : float {
        return 1 - $xy[0] - $xy[1];
    }

    static function getXYZ(array $xy) : array {
        return [ $xy[0], $xy[1], self::calculateZfromXY($xy) ];
    }
}
