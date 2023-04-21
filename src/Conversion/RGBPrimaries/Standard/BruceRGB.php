<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Bruce RGB color space primaries.
 */
class BruceRGB extends PrimariesAbstract {
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
