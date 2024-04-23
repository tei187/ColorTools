<?php

namespace tei187\ColorTools\Dictionaries\CAT\Matrices;

/**
 * Matrices used in Von Kries chromatic adaptation transform.
 * 
 * @deprecated 1.0.0
 */
class Von_Kries {
    /**
     * Nominal Von Kries CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX = [
        [  .40024,  .70760, -.08081 ],
        [ -.22630, 1.16532,  .04570 ],
        [       0,       0,  .91822 ]
    ];

    /**
     * Inverted Von Kries CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX_INVERTED = [
        [ 1.8599364, -1.1293816,   .2198974 ],
        [  .3611914,   .6388125,  -.0000064 ],
        [         0,          0,  1.0890636 ]
    ];
}