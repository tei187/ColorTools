<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Wide Gamut RGB color space primaries.
 */
class WideGamutRGB extends RGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Wide Gamut RGB";
    const XYY = [
        'R' => [ .735, .265, .258187 ],
        'G' => [ .115, .826, .724938 ],
        'B' => [ .157, .018, .016875 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 2.2;
}
