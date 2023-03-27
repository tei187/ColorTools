<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

class XYZ_Scaling {
    const MATRIX = [
        [  1, 0, 0 ],
        [  0, 1, 0 ],
        [  0, 0, 1 ]
    ];

    const MATRIX_INVERTED = [
        [  1, 0, 0 ],
        [  0, 1, 0 ],
        [  0, 0, 1 ]
    ];
}