<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class BetaRGB extends PrimariesAbstract {
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
