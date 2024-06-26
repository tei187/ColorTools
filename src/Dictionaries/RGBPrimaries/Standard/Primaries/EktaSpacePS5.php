<?php

namespace tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries;

use tei187\ColorTools\Abstracts\RGBPrimaries as RGBPrimariesAbstract;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

/**
 * Standard class for Ekta Space PS5 RGB color space primaries.
 */
class EktaSpacePS5 extends RGBPrimariesAbstract {
    use GammaCompanding;
    const NAME = "Ekta Space PS5";
    const XYY = [
        'R' => [ .695, .305, .2606229 ],
        'G' => [ .26,  .7,   .734946  ],
        'B' => [ .11,  .005, .004425  ]
    ];
    const ILLUMINANT = 'D50';
    const GAMMA = 2.2;
}
