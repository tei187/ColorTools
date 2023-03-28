<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

class CIECAT02 {
    const MATRIX = [
        [  .7328,  .4296, -.1624 ], 
        [ -.7036, 1.6975,  .0061 ], 
        [  .003,   .0136,  .9834 ]
    ];

    const MATRIX_INVERTED = [
        [ 1.0961238, -.278869,   .1827452 ],
        [  .454369,   .4735332,  .0720978 ],
        [ -.0096276, -.005698,  1.0153256 ]
    ];
}
