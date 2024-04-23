<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Bruce RGB color space primaries.
 */
class BruceRGB extends RGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Bruce RGB";
    const XYY = [
        'R' => [ .64, .33, .240995 ],
        'G' => [ .28, .65, .683554 ],
        'B' => [ .15, .06, .075452 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
