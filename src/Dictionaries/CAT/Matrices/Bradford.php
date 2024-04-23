<?php

namespace tei187\ColorTools\Dictionaries\CAT\Matrices;

/**
 * Matrices used in Bradford chromatic adaptation transform.
 * 
 * @deprecated 1.0.0
 */
class Bradford {
    /**
     * Nominal Bradford CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX = [
        [  .8951,  .2664,  -.1614 ],
        [ -.7502, 1.7135,   .0367 ],
        [  .0389, -.0685,  1.0296 ]
    ];

    /**
     * Inverted Bradford CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX_INVERTED = [
        [  .9869929, -.1470543,  .1599627 ],
        [  .4323053,  .5183603,  .0492912 ],
        [ -.0085287,  .0400428,  .9684867 ]
    ];
}