<?php

namespace tei187\ColorTools\Traits;

use Error;

/**
 * Used in classes that are direct dictionary illuminant classes.
 * Applicable only for Standard Illuminants with Standard Observers' angles.
 * 
 * *Reminder:* LED illuminants are only described in 2deg angle and will fallback to it.
 */
trait IsStandardIlluminant {
    public function __construct(int $angle = 2) {
        $this->name = basename(__CLASS__);
        $this->angle = $angle;
        if($this->angle === 10) {
            try {
                // found 10 deg
                $this->whitepoint = constant('\tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint10' . "::".$this->name);
                $this->tristimulus = constant('\tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus10' . "::".$this->name);
            } catch(Error $e) {
                // did not find 10 deg, default to 2 deg
                $this->whitepoint = constant('\tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint2' . "::".$this->name);
                $this->tristimulus = constant('\tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus2' . "::".$this->name);
                $this->angle == 2;
            }
        } else {
            $this->whitepoint = constant('\tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint2' . "::".$this->name);
            $this->tristimulus = constant('\tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus2' . "::".$this->name);
        }
    }
}