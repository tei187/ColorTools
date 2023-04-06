<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class AppleRGB {
    use GammaCompanding;
    const NAME = "Apple RGB";
    const XYY = [
        'R' => [ .625, .34, .244634 ],
        'G' => [ .28, .595, .672034 ],
        'B' => [ .155, .07, .083332 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 1.8;
}
