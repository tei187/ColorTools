<?php

namespace tei187\ColorTools\Dictionaries\Illuminants\Standard;

/**
 * Standard illuminants chromaticity x,y coordinates at 10 degree supplementary standard colorimetric observer (CIE 1964).
 * 
 * @link https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants
 */
Class WhitePoint10 {

    /** 
     * Incadescent / tungsten. 
     */
    const A = [ 0.45117, 0.40594 ];
    /** 
     * (obsolete) Direct sunlight at noon.
     */
    const B = [ 0.3498, 0.3527 ];
    /**
     * (obsolete) Average / North sky daylight / NTSC 1953, PAL-M.
     */
    const C = [ 0.31039, 0.31905 ];
    /**
     * Horizon light, ICC profile PCS.
     */
    const D50 = [ 0.34773, 0.35952 ];
    /**
     * Mid-morning / mid-afternoon daylight.
     */
    const D55 = [ 0.33411, 0.34877 ];
    /**
     * Noon daylight: television, sRGB color space.
     */
    const D65 = [ 0.31382, 0.331 ];
    /**
     * North sky daylight.
     */
    const D75 = [ 0.29968, 0.3174 ];
    /**
     * High-efficiency blue phosphor monitors, BT.2035.
     */
    const D93 = [ 0.28327, 0.30043 ];
    /**
     * Equal energy.
     */
    const E = [ 0.33333, 0.33333 ];
    /**
     * Daylight fluorescent.
     */
    const F1 = [ 0.31811, 0.33559 ];
    /**
     * Cool white fluorescent.
     */
    const F2 = [ 0.37925, 0.36733 ];
    /**
     * White fluorescent.
     */
    const F3 = [ 0.41761, 0.38324 ];
    /**
     * Warm white fluorescent.
     */
    const F4 = [ 0.4492, 0.39074 ];
    /**
     * Daylight fluorescent.
     */
    const F5 = [ 0.31975, 0.34246 ];
    /**
     * Light white fluorescent.
     */
    const F6 = [ 0.3866, 0.37847 ];
    /**
     * D65 simulator, daylight simulator.
     */
    const F7 = [ 0.31569, 0.3296 ];
    /**
     * D50 simulator, Sylvania F40 Design 50.
     */
    const F8 = [ 0.34902, 0.35939 ];
    /**
     * Cool white deluxe fluorescent.
     */
    const F9 = [ 0.37829, 0.37045 ];
    /**
     * Philips TL85, Ultralume 50.
     */
    const F10 = [ 0.3509, 0.35444 ];
    /**
     * Philips TL84, Ultralume 40.
     */
    const F11 = [ 0.38541, 0.37123 ];
    /**
     * Philips TL83, Ultralume 30.
     */
    const F12 = [ 0.44256, 0.39717 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B1 = [ 0.462505, 0.403042 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B2 = [ 0.442119, 0.396634 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B3 = [ 0.380852, 0.368518 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B4 = [ 0.348371, 0.345065 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B5 = [ 0.316927, 0.322060 ];
    /**
     * Mixing of phosphor-converted blue LED and red LED (blue-hybrid).
     */
    const LED_BH1 = [ 0.452773, 0.400032 ];
    /**
     * Mixing of red, green, and blue LEDs.
     */
    const LED_RGB1 = [ 0.457036, 0.425381 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_V1 = [ 0.453603, 0.398200 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_V2 = [ 0.377728, 0.374512 ];
}
