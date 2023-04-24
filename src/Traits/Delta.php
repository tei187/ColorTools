<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Delta\CIE76;
use tei187\ColorTools\Delta\CIE94;
use tei187\ColorTools\Delta\CIEDE2000;
use tei187\ColorTools\Delta\CMC_lc;
use tei187\ColorTools\Delta\Dictionary;
use tei187\ColorTools\Helpers\ArrayMethods;
use tei187\ColorTools\Helpers\ClassMethods;

trait Delta {
    /**
     * Checks if passed argument is proper to do deltaE calculations.
     *
     * @param mixed $data
     * @return array|false;
     */
    protected function _assessDeltaInputValues($data) {
        $validated = false;
        switch(gettype($data)) {
            case 'array':
                if(ArrayMethods::checkForKeys($data, 'lab') === TRUE) {
                    $validated = array_values($data);
                }
                break;
            case 'object':
                if( ClassMethods::checkForInterface($data, 'tei187\\ColorTools\\Interfaces\\Measure') &&
                    ClassMethods::checkForTrait($data, 'tei187\\ColorTools\\Traits\\Illuminants') && 
                    ClassMethods::checkForTrait($data, 'tei187\\ColorTools\\Traits\\ChromaticAdaptation')
                ) {
                    $validated = array_values($data->toLab()->getValues());
                }
                break;
            default:
                break;
        }
        return $validated;
    }

    /**
     * Calculates deltaE between current values and specified argument, using CIE76 algorithm.
     *
     * @param object|array $data Either a measure object (of any type) or array with Lab values.
     * @return float|false Float outcome if success, false on failure (indicates wrong input).
     */
    public function deltaCIE76($data) {
        $assessed = $this->_assessDeltaInputValues($data);
        return
            $assessed !== false
                ? CIE76::calculateDelta([ array_values($this->toLab()->getValues()), $assessed ])
                : false;
    }

    /**
     * Calculates deltaE between current values and specified argument, using CIE94 algorithm.
     *
     * @param object|array $data Either a measure object (of any type) or array with Lab values.
     * @param string $mode Switch for application, allows `self::MODE_GRAPHIC_ARTS` (default) or `self::MODE_TEXTILES`, corresponding to `'graphic_arts'` or `'textiles'` strings respectively.
     * @return float|false Float outcome if success, false on failure (indicates wrong input).
     */
    public function deltaCIE94($data, string $mode = CIE94::MODE_GRAPHIC_ARTS) {
        $assessed = $this->_assessDeltaInputValues($data);
        return
            $assessed !== false
                ? CIE94::calculateDelta([ array_values($this->toLab()->getValues()), $assessed ], $mode)
                : false;
    }

        /**
     * Calculates deltaE between current values and specified argument, using CMC l:c algorithm.
     *
     * @param object|array $data Either a measure object (of any type) or array with Lab values.
     * @param string $mode Mode switch for 'l' (lightness) and 'c' (chroma) values used in equations. self::MODE_ACCEPTABILITY (default, string "acceptability") for 2:1, self::MODE_IMPERCEPTABILITY (string "imperceptability") for 1:1.
     * @return float|false Float outcome if success, false on failure (indicates wrong input).
     */
    public function deltaCMClc($data, string $mode = CMC_lc::MODE_ACCEPTABILITY) {
        $assessed = $this->_assessDeltaInputValues($data);
        return
            $assessed !== false
                ? CMC_lc::calculateDelta([ array_values($this->toLab()->getValues()), $assessed ], $mode)
                : false;
    }

    /**
     * Calculates deltaE between current values and specified argument, using CIEDE2000 algorithm.
     *
     * @param object|array $data Either a measure object (of any type) or array with Lab values.
     * @return float|false Float outcome if success, false on failure (indicates wrong input).
     */
    public function deltaCIE00($data) {
        $assessed = $this->_assessDeltaInputValues($data);
        return
            $assessed !== false
                ? CIEDE2000::calculateDelta([ array_values($this->toLab()->getValues()), $assessed ])
                : false;
    }

    /**
     * Calculates deltaE between current values and specified argument, using specified algorithm.
     *
     * @param object|array $data Either a measure object (of any type) or array with Lab values.
     * @param string $algorithm Delta E measuring algorithm name. Refer to dictionary for short-hands. By default CIE76.
     * @param string|null $mode Applicable for CIE94 and CMC l:c algorithms only, defining measure mode. Null by default.
     * @return float|false Float outcome if success, false on failure (indicates wrong input of measure data or unrecognized algorithm name).
     */
    public function delta($data, $algorithm = 'CIE76', ?string $mode = null) {
        $assessed  = $this->_assessDeltaInputValues($data);
        $algorithm = Dictionary::assessDeltaEClass($algorithm);

        if($assessed && $algorithm) {
            switch($algorithm) {
                case 'CIE76':
                    $delta = $this->deltaCIE76($assessed);
                    break;
                case 'CIE94':
                    $delta = $this->deltaCIE94($assessed, is_null($mode) ? 'graphic_arts' : $mode);
                    break;
                case 'CIE00':
                case 'CIEDE2000':
                    $delta = $this->deltaCIE00($assessed);
                    break;
                case 'CMC_lc':
                    $delta = $this->deltaCMClc($assessed, is_null($mode) ? 'acceptability' : $mode);
                    break;
            }
            return $delta;
        }
        return false;
    }

    
}