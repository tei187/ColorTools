<?php

namespace tei187\ColorTools\StandardIlluminants;

/**
 * Calculated tristimulus for white points of standard illuminantes, based on 2 degrees standard colorimetric observer.
 * 
 * @link https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants
 */
Class Tristimulus2 {
    
    /** 
     * Incadescent / tungsten. 
     */
    const A = [ 1.09847, 1.00000, 0.35582 ];
    /** 
     * (obsolete) Direct sunlight at noon.
     */
    const B = [ 0.99093, 1.00000, 0.85313 ];
    /**
     * (obsolete) Average / North sky daylight / NTSC 1953, PAL-M.
     */
    const C = [ 0.98071, 1.00000, 1.18225 ];
    /**
     * Horizon light, ICC profile PCS.
     */
    const D50 = [ 0.96421, 1.00000, 0.82519 ];
    /**
     * Mid-morning / mid-afternoon daylight.
     */
    const D55 = [ 0.95680, 1.00000, 0.92148 ];
    /**
     * Noon daylight: television, sRGB color space.
     */
    const D65 = [ 0.95043, 1.00000, 1.08890 ];
    /**
     * North sky daylight.
     */
    const D75 = [ 0.94972, 1.00000, 1.22639 ];
    /**
     * High-efficiency blue phosphor monitors, BT.2035.
     */
    const D93 = [ 0.95301, 1.00000, 1.41274 ];
    /**
     * Equal energy.
     */
    const E = [ 1, 1, 1 ];
    /**
     * Daylight fluorescent.
     */
    const F1 = [ 0.92834, 1.00000, 1.03665 ];
    /**
     * Cool white fluorescent.
     */
    const F2 = [ 0.99145, 1.00000, 0.67316 ];
    /**
     * White fluorescent.
     */
    const F3 = [ 1.03753, 1.00000, 0.49861 ];
    /**
     * Warm white fluorescent.
     */
    const F4 = [ 1.09147, 1.00000, 0.38813 ];
    /**
     * Daylight fluorescent.
     */
    const F5 = [ 0.90872, 1.00000, 0.98723 ];
    /**
     * Light white fluorescent.
     */
    const F6 = [ 0.97309, 1.00000, 0.60191 ];
    /**
     * D65 simulator, daylight simulator.
     */
    const F7 = [ 0.95017, 1.00000, 1.08630 ];
    /**
     * D50 simulator, Sylvania F40 Design 50.
     */
    const F8 = [ 0.96413, 1.00000, 0.82333 ];
    /**
     * Cool white deluxe fluorescent.
     */
    const F9 = [ 1.00365, 1.00000, 0.67868 ];
    /**
     * Philips TL85, Ultralume 50.
     */
    const F10 = [ 0.96174, 1.00000, 0.81712 ];
    /**
     * Philips TL84, Ultralume 40.
     */
    const F11 = [ 1.00899, 1.00000, 0.64262 ];
    /**
     * Philips TL83, Ultralume 30.
     */
    const F12 = [ 1.08046, 1.00000, 0.39228 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B1 = [ 1.11820, 1.00000, 0.33399 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B2 = [ 1.08599, 1.00000, 0.40653 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B3 = [ 1.00886, 1.00000, 0.67714 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B4 = [ 0.97716, 1.00000, 0.87836 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_B5 = [ 0.96354, 1.00000, 1.12670 ];
    /**
     * Mixing of phosphor-converted blue LED and red LED (blue-hybrid).
     */
    const LED_BH1 = [ 1.10034, 1.00000, 0.35908 ];
    /**
     * Mixing of red, green, and blue LEDs.
     */
    const LED_RGB1 = [ 1.08217, 1.00000, 0.29257 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_V1 = [ 1.00264, 1.00000, 0.19613 ];
    /**
     * Phosphor-converted blue.
     */
    const LED_V2 = [ 1.00159, 1.00000, 0.64742 ];
}
