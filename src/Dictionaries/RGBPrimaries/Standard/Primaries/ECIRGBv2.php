<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\LCompanding;

/**
 * Standard class for ECI RGB v2 color space primaries.
 */
class ECIRGBv2 extends RGBPrimariesAbstract {
    use LCompanding;
    const NAME = "ECI RGB v2";
    const XYY = [
        'R' => [ .67, .33, .32025  ],
        'G' => [ .21, .71, .602071 ],
        'B' => [ .14, .08, .077679 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 'L*';
}
