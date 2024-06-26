<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBRGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Best RGB color space primaries.
 */
class BestRGB extends RGBRGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Best RGB";
    const XYY = [
        'R' => [ .7347, .2653, .228457 ],
        'G' => [ .215,  .775,  .737352 ],
        'B' => [ .13,   .035,  .034191 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 2.2;
}
