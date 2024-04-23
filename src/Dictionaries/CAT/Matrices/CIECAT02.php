<?php

namespace tei187\ColorTools\Dictionaries\CAT\Matrices;

/**
 * Matrices used in CIECAT02 chromatic adaptation transform.
 * 
 * @deprecated 1.0.0
 */
class CIECAT02 {
    /**
     * Nominal CIECAT02 CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX = [
        [  .7328,  .4296, -.1624 ], 
        [ -.7036, 1.6975,  .0061 ], 
        [  .003,   .0136,  .9834 ]
    ];

    /**
     * Inverted CIECAT02 CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX_INVERTED = [
        [ 1.0961238, -.278869,   .1827452 ],
        [  .454369,   .4735332,  .0720978 ],
        [ -.0096276, -.005698,  1.0153256 ]
    ];
}
