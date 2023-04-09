<?php

namespace tei187\ColorTools\Chromaticity;

use tei187\ColorTools\Helpers\CheckArray;

class Temperature {
    /**
     * Reciprocal temperature.
     * 
     * @see http://www.brucelindbloom.com/
     * 
     * @var float[]
     */
    const RT = [
          0.0e-6,  10.0e-6,  20.0e-6,  30.0e-6,  40.0e-6,  50.0e-6,
         60.0e-6,  70.0e-6,  80.0e-6,  90.0e-6, 100.0e-6, 125.0e-6,
        150.0e-6, 175.0e-6, 200.0e-6, 225.0e-6, 250.0e-6, 275.0e-6,
        300.0e-6, 325.0e-6, 350.0e-6, 375.0e-6, 400.0e-6, 425.0e-6,
        450.0e-6, 475.0e-6, 500.0e-6, 525.0e-6, 550.0e-6, 575.0e-6,
        600.0e-6
    ];

    /**
     * Correlated u, v and T values.
     * 
     * @see http://www.brucelindbloom.com/
     * 
     * @var float[][]
     */
    const UVT = [
        [  .18006,  .26352,   -.24341 ],
        [  .18066,  .26589,   -.25479 ],
        [  .18133,  .26846,   -.26876 ],
        [  .18208,  .27119,   -.28539 ],
        [  .18293,  .27407,   -.30470 ],
        [  .18388,  .27709,   -.32675 ],
        [  .18494,  .28021,   -.35156 ],
        [  .18611,  .28342,   -.37915 ],
        [  .18740,  .28668,   -.40955 ],
        [  .18880,  .28997,   -.44278 ],
        [  .19032,  .29326,   -.47888 ],
        [  .19462,  .30141,   -.58204 ],
        [  .19962,  .30921,   -.70471 ],
        [  .20525,  .31647,   -.84901 ],
        [  .21142,  .32312,  -1.0182  ],
        [  .21807,  .32909,  -1.2168  ],
        [  .22511,  .33439,  -1.4512  ],
        [  .23247,  .33904,  -1.7298  ],
        [  .24010,  .34308,  -2.0637  ],
        [  .24792,  .34655,  -2.4681  ],
        [  .25591,  .34951,  -2.9641  ],
        [  .26400,  .35200,  -3.5814  ],
        [  .27218,  .35407,  -4.3633  ],
        [  .28039,  .35577,  -5.3762  ],
        [  .28863,  .35714,  -6.7262  ],
        [  .29685,  .35823,  -8.5955  ],
        [  .30505,  .35907,  -11.324  ],
        [  .31320,  .35968,  -15.628  ],
        [  .32129,  .36011,  -23.325  ],
        [  .32931,  .36038,  -40.770  ],
        [  .33724,  .36051, -116.45   ]
    ];

    /**
     * Calculates correlated color temperature (CCT), based on A. R. Robertson method.
     *
     * @see http://www.brucelindbloom.com/
     * 
     * @param array $xyz Input XYZ color data.
     * @return false|float Float if correct, FALSE if temperature out of bounds.
     */
    static public function XYZ_to_temp(array $xyz) {
        list($X, $Y, $Z) = 
            isset($xyz['values'])
                ? CheckArray::makeList($xyz['values'], 'XYZ')
                : CheckArray::makeList($xyz, 'XYZ');
        
        if($X < 1.0e-20 && $Y < 1.0e-20 && $Z < 1.0e-20) {
            return(false);
        }

        $us = (4.0 * $X) / ($X + (15.0 * $Y) + (3.0 * $Z));
        $vs = (6.0 * $Y) / ($X + (15.0 * $Y) + (3.0 * $Z));
        $dm = 0.0;

        for($i = 0; $i < 31; $i++) {
            $di = ($vs - self::UVT[$i][1] - self::UVT[$i][2] * ($us - self::UVT[$i][0]));
            if (($i > 0) && ((($di < 0.0) && ($dm >= 0.0)) || (($di >= 0.0) && ($dm < 0.0)))) {
                break;
            }
            $dm = $di;
        }
        if($i == 31) {
            return(false);
        }
        $di = $di / sqrt(1.0 + pow(self::UVT[$i][2], 2));
        $dm = $dm / sqrt(1.0 + pow(self::UVT[$i-1][2], 2));
        $p = $dm / ( $dm - $di);
        $p = 1.0 / (self::RT[$i - 1] + ((self::RT[$i] - self::RT[$i - 1]) * $p));
        return $p;
    }
}
