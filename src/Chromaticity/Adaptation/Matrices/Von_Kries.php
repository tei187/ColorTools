<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

class Von_Kries {
    const MATRIX = [
        [  .40024,  .70760, -.08081 ],
        [ -.22630, 1.16532,  .04570 ],
        [       0,       0,  .91822 ]
    ];

    const MATRIX_INVERTED = [
        [ 1.8599364, -1.1293816,   .2198974 ],
        [  .3611914,   .6388125,  -.0000064 ],
        [         0,          0,  1.0890636 ]
    ];
}