<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\sRGBCompanding;

class sRGB {
    use sRGBCompanding;
    const NAME = "sRGB";
    const XYY = [
        'R' => [ .64, .33,  .212656 ],
        'G' => [ .3,  .6,   .715158 ],
        'B' => [ .15, .018, .072186 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
