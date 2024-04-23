<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Beta RGB color space primaries.
 */
class BetaRGB extends RGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Beta RGB";
    const XYY = [
        'R' => [ .6888, .3112, .303273 ],
        'G' => [ .1986, .7551, .663786 ],
        'B' => [ .1265, .0352, .032941 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 2.2;
}
