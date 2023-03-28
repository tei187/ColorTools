<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

class Sharp {
    const MATRIX = [
        [ 1.2694, -.0988, -.1706 ],
        [ -.8364, 1.8006,  .0357 ],
        [  .0297, -.0315, 1.0018 ]
    ];

    const MATRIX_INVERTED = [
        [  .8156333,  .0471548,  .1372166 ],
        [  .3791144,  .5769424,  .0440009 ],
        [ -.0122601,  .0167431,  .9955188 ]
    ];
}
