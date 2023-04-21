<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for ColorMatch RGB color space primaries.
 */
class ColorMatchRGB extends PrimariesAbstract {
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
