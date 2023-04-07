<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class EktaSpacePS5 extends PrimariesAbstract {
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
