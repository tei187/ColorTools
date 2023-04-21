<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\sRGBCompanding;

/**
 * Standard class for sRGB color space primaries.
 */
class sRGB extends PrimariesAbstract {
    use sRGBCompanding;
    const NAME = "sRGB";
    const XYY = [
        'R' => [ .64, .33,  .212656 ],
        'G' => [ .3,  .6,   .715158 ],
        'B' => [ .15, .06, .072186 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
