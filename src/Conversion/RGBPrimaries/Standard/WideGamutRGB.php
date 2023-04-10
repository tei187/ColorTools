<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class WideGamutRGB extends PrimariesAbstract {
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
