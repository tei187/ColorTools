<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class BestRGB extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "Best RGB";
    const XYY = [
        'R' => [ .7347, .2653, .228457 ],
        'G' => [ .215,  .775,  .737352 ],
        'B' => [ .13,   .035,  .034191 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 2.2;
}
