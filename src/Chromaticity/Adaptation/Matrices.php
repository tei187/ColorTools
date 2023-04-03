<?php

namespace tei187\ColorTools\Chromaticity\Adaptation;

/**
 * All nominal matrices for different chromatic adaptation transformation methods.
 */
class Matrices {
    /**
     * Nominal XYZ Scaling CAT matrix.
     * @var array<array<float>>
     */
    const XYZ_Scaling = [
        [  1, 0, 0 ],
        [  0, 1, 0 ],
        [  0, 0, 1 ]
    ];
    
    /**
     * Nominal Von Kries CAT matrix.
     * @var array<array<float>>
     */
    const Von_Kries = [
        [  .40024,  .70760, -.08081 ],
        [ -.22630, 1.16532,  .04570 ],
        [       0,       0,  .91822 ]
    ];
    
    /**
     * Nominal Bradford CAT matrix.
     * @var array<array<float>>
     */
    const Bradford = [
        [   .8951,   .2664,  -.1614 ],
        [  -.7502,  1.7135,   .0367 ],
        [   .0389,  -.0685,  1.0296 ]
    ];

    /**
     * Nominal CMCCAT2000 CAT matrix.
     * @var array<array<float>>
     */
    const CMCCAT2000 = [
        [   .7982,   .3389,  -.1371 ],
        [  -.5918,  1.5512,   .0406 ],
        [   .0008,   .0239,   .9753 ]
    ];

    /**
     * Nominal CIECAT02 CAT matrix.
     * @var array<array<float>>
     */
    const CIECAT02 = [
        [   .7328,   .4296,  -.1624 ], 
        [  -.7036,  1.6975,   .0061 ], 
        [   .003,    .0136,   .9834 ]
    ];

    /**
     * Nominal Sharp CAT matrix.
     * @var array<array<float>>
     */
    const Sharp = [
        [  1.2694,  -.0988,  -.1706 ],
        [  -.8364,  1.8006,   .0357 ],
        [   .0297,  -.0315,  1.0018 ]
    ];

    /**
     * Nominal Hunt-Pointer-Esteves CAT matrix.
     * @var array<array<float>>
     */
    const HuntPointerEsteves = [
        [  .38971,   .68898,  -.07868 ],
        [ -.22981,  1.18340,   .04641 ],
        [       0,        0,        1 ]
    ];
}