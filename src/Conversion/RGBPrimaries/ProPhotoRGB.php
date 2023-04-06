<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class ProPhotoRGB {
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
