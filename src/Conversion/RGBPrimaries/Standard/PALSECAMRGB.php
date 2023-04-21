<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for PAL/SECAM RGB color space primaries.
 */
class PALSECAMRGB extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "PAL/SECAM RGB";
    const XYY = [
        'R' => [ .64, .33, .222021 ],
        'G' => [ .29, .6,  .706645 ],
        'B' => [ .15, .06, .071334 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
