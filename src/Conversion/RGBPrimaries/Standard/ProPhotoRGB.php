<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for ProPhoto RGB color space primaries.
 */
class ProPhotoRGB extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "ProPhoto RGB";
    const XYY = [
        'R' => [ .7347, .2653, .28804  ],
        'G' => [ .1596, .8404, .711874 ],
        'B' => [ .0366, .0001, .000086 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 1.8;
}
