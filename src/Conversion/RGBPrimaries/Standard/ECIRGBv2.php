<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\LCompanding;

class ECIRGBv2 extends PrimariesAbstract {
    use LCompanding;
    const NAME = "ECI RGB v2";
    const XYY = [
        'R' => [ .67, .33, .32025  ],
        'G' => [ .21, .71, .602071 ],
        'B' => [ .14, .08, .077679 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 'L*';
}
