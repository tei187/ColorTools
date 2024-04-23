<?php

namespace tei187\ColorTools\Dictionaries\Illuminants\Standard;

use tei187\ColorTools\Abstracts\IlluminantDictionary as DictionaryAbstract;


/**
 * Represents a dictionary of standard illuminants.
 * 
 * Available illuminants white point information for 2&deg; and 10&deg; standard observers:
 * A, B, C, D50, D55, D65, D75, D93, E, F1, F2, F3, F4, F5, F6, F7, F8, F9, F10, F11, F12.
 * 
 * Also for LED-series illuminants, available only for 2&deg; standard observer:
 * LED_B1, LED_B2, LED_B3, LED_B4, LED_B5, LED_BH1, LED_RGB1, LED_V1, LED
 */
class Dictionary extends DictionaryAbstract
{

    /**
     * Array of names corresponding to illuminants defined by this dictionary.
     * 
     * @var string[]
     */
    const INDEX = [
        'A',
        'B',
        'C',
        'D50', 'D55', 'D65', 'D75', 'D93',
        'E',
        'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'F10', 'F11', 'F12',
        'LED_B1', 'LED_B2', 'LED_B3', 'LED_B4', 'LED_B5', 'LED_BH1', 'LED_RGB1', 'LED_V1', 'LED_V2',
    ];

    /**
     * Defines the standard observer angles (in degrees) for which the white point
     * and tristimulus values are defined in this dictionary.

     * If any of the methods requires a specific angle and it is not being passed,
     * the first item in the list will be used as default.
     * 
     * @var int[]
     */ 
    const ANGLES = [2,10];

    /**
     * Namespace for (x,y) white point constans values defined by this dictionary
     * (without the degree interger at the end). It will be required to follow this
     * formatting.
     * 
     * @var string
     */
    const WHITEPOINT = "\\tei187\\ColorTools\\Dictionaries\\Illuminants\\Standard\\WhitePoint";
}