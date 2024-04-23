<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Helpers\ClassMethods;
use tei187\ColorTools\Math\ModelConversion;
use tei187\ColorTools\Math\Chromaticity\Adaptation as AdaptationMath;
use tei187\ColorTools\Dictionaries\CAT\Matrices;
use tei187\ColorTools\Interfaces\IlluminantDictionary;
use tei187\ColorTools\Dictionaries\Illuminants\Standard\Dictionary as StandardIlluminantDictionary;
use tei187\ColorTools\Illuminants\Illuminant;
use tei187\ColorTools\ColorModels\XYZ;

/**
 * Trait allowing use of public functions meant to apply chromatic adaptation methods for measure/swatch objects. **IMPORTANT!** Dependable on using 'Illuminants' trait.
 */
trait ChromaticAdaptation {
    /**
     * Applies chromatic adaptation to the color values of the current object using the specified destination illuminant and chromatic adaptation transform (CAT).
     *
     * @param mixed $destination The destination illuminant to adapt the color to.
     * @param mixed $CAT The chromatic adaptation transform to use, defaults to Bradford.
     * @return array|false The adapted XYZ color values, or false if the 'UsesIlluminant' trait is not present.
     * @throws \Exception if the 'UsesIlluminant' trait is not present.
     */
    public function getAdaptedValues($destination, $CAT = Matrices::Bradford)
    {
        if (ClassMethods::checkForTrait($this, 'tei187\\ColorTools\\Traits\\UsesIlluminant')) {
            return AdaptationMath::adapt(
                $this->toXYZ()->getValues(), 
                $this->getIlluminant()->get('whitepoint'), 
                $destination, 
                $CAT
            );
        }
        throw new \Exception('Object does not use the UsesIlluminant trait, cannot apply chromatic adaptation.');
        return false;
    }

    /**
     * Returns a new object with the adapted XYZ values.
     *
     * This method adapts the current object's XYZ values to the specified destination white point using the provided chromatic adaptation transform.
     *
     * @param mixed $destination Name, xy chromatic coordinates or XYZ tristimulus of destination white point.
     * @param mixed $CAT Chromatic adaptation transformation. By default uses Bradford CAT.
     * @param IlluminantDictionary $dictionary Dictionary of standard illuminants. By default uses the 'Dictionary\Illuminants\Standard' class.
     * @return object A new object with the adapted XYZ values, or false on failure. Output class is based on current object's class.
     * @throws \Exception if the 'UsesIlluminant' trait is not present.
     * @throws \Exception if passed destination white point is invalid.
     */
    public function adapt($destination, $CAT = Matrices::Bradford, IlluminantDictionary $dictionary = new StandardIlluminantDictionary)
    {
        if (ClassMethods::checkForTrait($this, 'tei187\\ColorTools\\Traits\\UsesIlluminant')) {
            if(is_string($destination)) {
                $destination = Illuminant::from( $dictionary::assessStandardIlluminant($destination), $this->getIlluminant()->get('angle') );
                if($destination === null) {
                    throw new \Exception("Invalid illuminant destination specified. Passed string \".$destination.\" does not correspont with any standard illuminant found in the dictionary ".get_class($dictionary).".");
                }
            } elseif(is_array($destination)) {
                switch(count($destination)) {
                    case 2:
                        $destination = new Illuminant($destination); break;
                    case 3:
                        $destination = new Illuminant(ModelConversion::tristimulus_to_chromaticity($destination)); break;
                    default:
                        throw new \Exception("Invalid illuminant destination specified. Passed array cannot be identified as either (x,y) whitepoint or (X,Y,Z) tristimulus.");
                }
            }

            $class = explode("\\", get_class($this));
            $current = $class[array_key_last($class)];
            $xyz_adapted = $this->getAdaptedValues($destination->getWhitepoint(), $CAT);

            $obj = new XYZ(
                $xyz_adapted,
                $destination
            );

            $new = $obj->to(
                $current,
                isset($this->primaries) ? $this->primaries : 'sRGB'
            );

            return $new;
        }
        throw new \Exception('Object does not use the UsesIlluminant trait, cannot apply chromatic adaptation.');
        return false;
    }
}