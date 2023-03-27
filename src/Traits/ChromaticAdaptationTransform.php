<?php

namespace tei187\ColorTools\Traits;

// http://www.russellcottrell.com/photo/matrixCalculator.htm
// https://www.xrite.com/pl-pl/service-support/chromaticadaptationwhatisitwhatdoesitdo

trait ChromaticAdaptationTransform {
    protected $MA_Bradford = [
        [  .8951,   .2664,  -.1614 ],
        [ -.7502,  1.7135,   .0367 ],
        [  .0389,  -.0685, -1.0296 ]
    ];

    protected $MA_CMCCAT2000 = [
        [  .7982,  .3389, -.1371 ],
        [ -.5918, 1.5512,  .0406 ],
        [  .0008,  .0239,  .9753 ]
    ];

    protected $MA_CIECAT02 = [
        [  .7328,  .4296, -.1624 ], 
        [ -.7036, 1.6975,  .0061 ], 
        [  .003,   .0136,  .9834 ]
    ];

    protected $MA_Sharp = [
        [ 1.2694, -.0988, -.1706 ],
        [ -.8364, 1.8006,  .0357 ],
        [  .0297, -.0315, 1.0018 ]
    ];
}