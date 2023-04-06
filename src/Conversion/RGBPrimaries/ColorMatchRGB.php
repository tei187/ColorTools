<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class ColorMatchRGB {
    use GammaCompanding;
    const NAME = "ColorMatch RGB";
    const XYY = [
        'R' => [ .63,  .34,  .274884 ],
        'G' => [ .295, .605, .658132 ],
        'B' => [ .15,  .075, .066985 ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 1.8;
}
