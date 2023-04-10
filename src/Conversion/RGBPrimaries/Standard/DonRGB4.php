<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class DonRGB4 extends PrimariesAbstract {
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
