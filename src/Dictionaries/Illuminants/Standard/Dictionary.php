<?php

namespace tei187\ColorTools\Dictionaries\Illuminants\Standard;

use tei187\ColorTools\Abstracts\IlluminantDictionary as DictionaryAbstract;
use tei187\ColorTools\Interfaces\Illuminant as IlluminantInterface;
use tei187\ColorTools\Interfaces\StandardIlluminant as StandardIlluminantInterface;
use tei187\ColorTools\Illuminants\Illuminant;


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

    /**
     * Looks up the illuminant object for the specified name and angle and returns as Illuminant if found.
     *
     * @param string $name The name of the standard illuminant, e.g. "D65", "A", "F11".
     * @param int $angle The angle of the standard illuminant, typically 2 or 10 degrees. Defaults to 2 degrees if not provided.
     * @return IlluminantInterface|StandardIlluminantInterface Returns illuminant if found in dictionary.
     */   
    public static function getIlluminant(string $name, ?int $angle = null) {
        if(in_array($name, self::INDEX)) {
            $classname = '\\tei187\\ColorTools\\Illuminants\\Standard\\' . $name;
            return new $classname($angle);
        }
        return new Illuminant(self::getChromaticCoordinates($name, $angle), $angle, $name);
    }
}