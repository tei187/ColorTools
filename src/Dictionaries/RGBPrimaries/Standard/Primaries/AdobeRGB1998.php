<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBRGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Adobe RGB (1998) color space primaries.
 */
class AdobeRGB1998 extends RGBRGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Adobe RGB (1998)";
    const XYY = [
        'R' => [ .64, .33, .297361 ],
        'G' => [ .21, .71, .627355 ],
        'B' => [ .15, .06, .075285 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
