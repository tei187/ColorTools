<?php

namespace tei187\ColorTools\Chromaticity\Adaptation\Matrices;

class CMCCAT2000 {
    const MATRIX = [
        [  .7982,  .3389, -.1371 ],
        [ -.5918, 1.5512,  .0406 ],
        [  .0008,  .0239,  .9753 ]
    ];

    const MATRIX_INVERTED = [
        [ 1.07645,   -.2376624,  .1612123 ],
        [  .4109643,  .5543418,  .0346939 ],
        [ -.0109538, -.0133894, 1.0243431 ]
    ];
}
