<?php

namespace tei187\ColorTools\StandardIlluminants;

/**
 * Standard illuminants chromaticity x,y coordinates at 2 degree standard colorimetric observer (CIE 1931).
 * 
 * @link https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants
 */
Class WhitePoint2 {

    /** 
     * Incadescent / tungsten. 
     */
    const A = [ 0.44757, 0.40745 ];
    /** 
     * (obsolete) Direct sunlight at noon.
     */
    const B = [ 0.34842, 0.35161 ];
    /**
     * (obsolete) Average / North sky daylight / NTSC 1953, PAL-M.
     */
    const C = [ 0.31006, 0.31616 ];
    /**
     * Horizon light, ICC profile PCS.
     */
    const D50 = [ 0.34567, 0.3585 ];
    /**
     * Mid-morning / mid-afternoon daylight.
     */
    const D55 = [ 0.33242, 0.34743 ];
    /**
     * Noon daylight: television, sRGB color space.
     */
    const D65 = [ 0.31271, 0.32902 ];
    /**
     * North sky daylight.
     */
    const D75 = [ 0.29902, 0.31485 ];
    /**
     * High-efficiency blue phosphor monitors, BT.2035.
     */
    const D93 = [ 0.28315, 0.29711 ];
    /**
     * Equal energy.
     */
    const E = [ 0.33333, 0.33333 ];
    /**
     * Daylight fluorescent.
     */
    const F1 = [ 0.3131, 0.33727 ];
    /**
     * Cool white fluorescent.
     */
    const F2 = [ 0.37208, 0.37529 ];
    /**
     * White fluorescent.
     */
    const F3 = [ 0.4091, 0.3943 ];
    /**
     * Warm white fluorescent.
     */
    const F4 = [ 0.44018, 0.40329 ];
    /**
     * Daylight fluorescent.
     */
    const F5 = [ 0.31379, 0.34531 ];
    /**
     * Light white fluorescent.
     */
    const F6 = [ 0.3779, 0.38835 ];
    /**
     * D65 simulator, daylight simulator.
     */
    const F7 = [ 0.31292, 0.32933 ];
    /**
     * D50 simulator, Sylvania F40 Design 50.
     */
    const F8 = [ 0.34588, 0.35875 ];
    /**
     * Cool white deluxe fluorescent.
     */
    const F9 = [ 0.37417, 0.37281 ];
    /**
     * Philips TL85, Ultralume 50.
     */
    const F10 = [ 0.34609, 0.35986 ];
    /**
     * Philips TL84, Ultralume 40.
     */
    const F11 = [ 0.38052, 0.37713 ];
    /**
     * Philips TL83, Ultralume 30.
     */
    const F12 = [ 0.43695, 0.40441 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B1 = [ 0.456, 0.4078 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B2 = [ 0.4357, 0.4012 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B3 = [ 0.3756, 0.3723 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B4 = [ 0.3422, 0.3502 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B5 = [ 0.3118, 0.3236 ];
    /**
     * Mixing of phosphor-converted blue LED and red LED (blue-hybrid).
     */
    const LED_BH1 = [ 0.4474, 0.4066 ];
    /**
     * Mixing of red, green, and blue LEDs.
     */
    const LED_RGB1 = [ 0.4557, 0.4211 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_V1 = [ 0.456, 0.4548 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_V2 = [ 0.3781, 0.3775 ];
}
