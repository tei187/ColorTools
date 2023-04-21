<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for CIE RGB color space primaries.
 */
class CIERGB extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "CIE RGB";
    const XYY = [
        'R' => [ .735, .265, .176204 ],
        'G' => [ .274, .717, .812985 ],
        'B' => [ .167, .009, .010811 ]
    ];
    const ILLUMINANT = 'E';
    const GAMMA = 2.2;
}
