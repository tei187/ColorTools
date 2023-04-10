<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class AdobeRGB1998 extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "Adobe RGB (1998)";
    const XYY = [
        'R' => [ .64, .33, .297361 ],
        'G' => [ .21, .71, .627355 ],
        'B' => [ .15, .06, .075285 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
