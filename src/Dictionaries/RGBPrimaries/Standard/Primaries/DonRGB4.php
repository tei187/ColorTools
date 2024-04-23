<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Don RGB 4 color space primaries.
 */
class DonRGB4 extends RGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Don RGB 4";
    const XYY = [
        'R' => [ .696, .3,   .278350 ],
        'G' => [ .215, .765, .68797  ],
        'B' => [ .13,  .035, .03368  ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 2.2;
}
