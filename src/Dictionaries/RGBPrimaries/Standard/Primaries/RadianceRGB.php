<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Radiance RGB color space primaries.
 */
class RadianceRGB extends RGBPrimariesAbstract {
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
