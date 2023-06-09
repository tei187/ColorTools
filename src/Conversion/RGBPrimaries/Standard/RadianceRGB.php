<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Radiance RGB color space primaries.
 */
class RadianceRGB extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "Radiance RGB";
    const XYY = [
        'R' => [ .64, .33,  .212656 ],
        'G' => [ .3,  .6,   .715158 ],
        'B' => [ .15, .06, .072186 ]
    ];
    const ILLUMINANT = 'E';
    const GAMMA = 1.8;
}
