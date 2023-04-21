<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries\Standard;
use tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for SMPTE-C RGB color space primaries.
 */
class SMPTECRGB extends PrimariesAbstract {
    use GammaCompanding;
    const NAME = "SMPTE-C RGB";
    const XYY = [
        'R' => [ .63,  .34,  .212395 ],
        'G' => [ .31,  .595, .701049 ],
        'B' => [ .155, .07,  .086556 ]
    ];
    const ILLUMINANT = 'D65';
    const GAMMA = 2.2;
}
