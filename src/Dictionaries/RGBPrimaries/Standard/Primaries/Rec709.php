<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\Rec709Companding;

/**
 * Standard class for Rec709 color space primaries.
 * 
 * Primaries assumed to be the same as with sRGB.
 */
class Rec709 extends RGBPrimariesAbstract {
    use Rec709Companding;
    const NAME = "Rec.709";
    const XYY = [
        'R' => [ .64, .33, .212656 ],
        'G' => [ .3,  .6,  .715158 ],
        'B' => [ .15, .06, .072186 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
