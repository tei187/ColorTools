<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Helpers\ClassMethods;
use tei187\ColorTools\Chromaticity\Adaptation\Adaptation;
use tei187\ColorTools\Chromaticity\Adaptation\Matrices;
use tei187\ColorTools\Measures\XYZ;

trait ChromaticAdaptation {
    /**
     * Undocumented function
     *
     * @param mixed $destination
     * @param mixed $CAT
     * @return array|false
     */
    public function getAdaptedValues($destination, $CAT = Matrices::Bradford) {
        if(ClassMethods::checkForTrait($this, 'tei187\\ColorTools\\Traits\\Illuminants')) {
            return Adaptation::adapt($this->toXYZ()->getValues(), $this->getIlluminantTristimulus(), $destination, $CAT);
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param mixed $destination
     * @param mixed $CAT
     * @return object|false
     */
    public function adapt($destination, $CAT = Matrices::Bradford) {
        if(ClassMethods::checkForTrait($this, 'tei187\\ColorTools\\Traits\\Illuminants')) {
            $class = explode("\\", get_class($this));
            $current = $class[array_key_last($class)];
            $xyz_adapted = $this->getAdaptedValues($destination, $CAT);
    
            $obj = new XYZ();
            $obj->setValues($xyz_adapted)
                ->setIlluminant(
                    $destination, 
                    $this->getIlluminantAngle()
                );

            $new = $obj->to(
                    $current, 
                    isset($this->primaries) ? $this->primaries : null
                );

            return $new;
        }
        return false;
    }
}