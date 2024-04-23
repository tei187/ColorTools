<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBRGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Apple RGB color space primaries.
 */
class AppleRGB extends RGBRGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Apple RGB";
    const XYY = [
        'R' => [ .625, .34, .244634 ],
        'G' => [ .28, .595, .672034 ],
        'B' => [ .155, .07, .083332 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 1.8;
}
