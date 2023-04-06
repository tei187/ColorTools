<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;
use tei187\ColorTools\Traits\Companding\GammaCompanding;

class NTSCRGB {
    use GammaCompanding;
    const NAME = "NTSC RGB";
    const XYY = [
        'R' => [ .67, .33, .298839 ],
        'G' => [ .21, .71, .586811 ],
        'B' => [ .14, .08, .11435  ]
    ];
    const ILLUMINANT = 'C';
    const GAMMA = 2.2;
}
