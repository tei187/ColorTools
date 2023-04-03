<?php

namespace tei187\ColorTools\StandardIlluminants;

/**
 * Calculated tristimulus for white points of standard illuminantes, based on 10 degrees standard colorimetric observer.
 * 
 * @link https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants
 */
Class Tristimulus10 {
    
    /** 
     * Incadescent / tungsten. 
     */
    const A = [ 1.11142, 1.00000, 0.35200 ];
    /** 
     * (obsolete) Direct sunlight at noon.
     */
    const B = [ 0.99178, 1.00000, 0.84349 ];
    /**
     * (obsolete) Average / North sky daylight / NTSC 1953, PAL-M.
     */
    const C = [ 0.97286, 1.00000, 1.16145 ];
    /**
     * Horizon light, ICC profile PCS.
     */
    const D50 = [ 0.96721, 1.00000, 0.81428 ];
    /**
     * Mid-morning / mid-afternoon daylight.
     */
    const D55 = [ 0.95797, 1.00000, 0.90925 ];
    /**
     * Noon daylight: television, sRGB color space.
     */
    const D65 = [ 0.94810, 1.00000, 1.07305 ];
    /**
     * North sky daylight.
     */
    const D75 = [ 0.94417, 1.00000, 1.20643 ];
    /**
     * High-efficiency blue phosphor monitors, BT.2035.
     */
    const D93 = [ 0.94288, 1.00000, 1.38568 ];
    /**
     * Equal energy.
     */
    const E = [ 1, 1, 1 ];
    /**
     * Daylight fluorescent.
     */
    const F1 = [ 0.94791, 1.00000, 1.03191 ];
    /**
     * Cool white fluorescent.
     */
    const F2 = [ 1.03245, 1.00000, 0.68990 ];
    /**
     * White fluorescent.
     */
    const F3 = [ 1.08968, 1.00000, 0.51965 ];
    /**
     * Warm white fluorescent.
     */
    const F4 = [ 1.14961, 1.00000, 0.40963 ];
    /**
     * Daylight fluorescent.
     */
    const F5 = [ 0.93369, 1.00000, 0.98636 ];
    /**
     * Light white fluorescent.
     */
    const F6 = [ 1.02148, 1.00000, 0.62074 ];
    /**
     * D65 simulator, daylight simulator.
     */
    const F7 = [ 0.95780, 1.00000, 1.07618 ];
    /**
     * D50 simulator, Sylvania F40 Design 50.
     */
    const F8 = [ 0.97115, 1.00000, 0.81135 ];
    /**
     * Cool white deluxe fluorescent.
     */
    const F9 = [ 1.02116, 1.00000, 0.67826 ];
    /**
     * Philips TL85, Ultralume 50.
     */
    const F10 = [ 0.99001, 1.00000, 0.83134 ];
    /**
     * Philips TL84, Ultralume 40.
     */
    const F11 = [ 1.03820, 1.00000, 0.65555 ];
    /**
     * Philips TL83, Ultralume 30.
     */
    const F12 = [ 1.11428, 1.00000, 0.40353 ];
}
