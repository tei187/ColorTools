<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

/**
 * Matrices used in XYZ Scaling chromatic adaptation transform.
 */
class XYZ_Scaling {
    /**
     * Nominal XYZ Scaling CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX = [
        [  1, 0, 0 ],
        [  0, 1, 0 ],
        [  0, 0, 1 ]
    ];

    /**
     * Inverted XYZ Scaling CAT matrix.
     * @var array<array<float>>
     */
    const MATRIX_INVERTED = [
        [  1, 0, 0 ],
        [  0, 1, 0 ],
        [  0, 0, 1 ]
    ];
}