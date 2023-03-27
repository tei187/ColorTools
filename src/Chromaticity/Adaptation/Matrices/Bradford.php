<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

class Bradford {
    const MATRIX = [
        [  .8951,  .2664,  -.1614 ],
        [ -.7502, 1.7135,   .0367 ],
        [  .0389, -.0685,  1.0296 ]
    ];

    const MATRIX_INVERTED = [
        [  .9869929, -.1470543,  .1599627 ],
        [  .4323053,  .5183603,  .0492912 ],
        [ -.0085287,  .0400428,  .9684867 ]
    ];
}