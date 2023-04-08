<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Conversion\Convert;

trait Illuminants {
    /**
     * Illuminant xy values.
     *
     * @var array
     */
    protected $illuminant = [];
    /**
     * Illuminant XYZ tristimulus values.
     *
     * @var array
     */
    protected $illuminantT = [];
    /**
     * Standard illuminant name, if applicable. Otherwise `null`.
     *
     * @var ?string
     */
    protected $illuminantName = null;

    /**
     * Sets values and angle of illuminant used during measurement.
     *
     * @param array|string $illuminant Array with 2 values (x,y) or string corresponding a constant name in specific Standard Illuminants static class.
     * @param integer $angle Integer `2` or `10`, specifying Standard Observer angle.
     * @return self|false Returns self-object if proper values, false if error occurred.
     */
    public function setIlluminant($illuminant, int $angle = 2) {
        if(is_string($illuminant)) {
            $data = constant("\\tei187\\ColorTools\\StandardIlluminants\\WhitePoint".$angle."::".strtoupper(trim($illuminant)));
            if($data !== null) {
                $this->illuminantName = strtoupper(trim($illuminant));
                $illuminant = array_values($data);
                $this->illuminant = [ 'x' => $illuminant[0], 'y' => $illuminant[1] ];
            } else {
                $this->illuminantName = null;
                $this->illuminant = [];
                $this->illuminantT = [];
                return false; // standard illuminant not found
            }
        } elseif(is_array($illuminant) && count($illuminant) == 2) {
            $illuminant = array_values($illuminant);
            $this->illuminant = [ 'x' => $illuminant[0], 'y' => $illuminant[1] ];
        } else {
            // @todo
            // maybe check for object, if illuminant objects exist?
            return false;
        }
        $this->illuminantT = Convert::chromaticity_to_tristimulus($this->illuminant);
        return $this;
    }

    /**
     * Returns array with illuminant x,y position.
     *
     * @return array
     */
    public function getIlluminantXY() : array {
        return $this->illuminant;
    }

    /**
     * Returns array with XYZ of tristimulus of illuminant.
     *
     * @return array
     */
    public function getIlluminantTristimulus() : array {
        return $this->illuminantT;
    }

    public function getIlluminantName() : ?string {
        return $this->illuminantName;
    }

    public function setIlluminantTristimulus(array $tristimulus) : parent {
        $this->illuminantT = $tristimulus;
        return $this;
    }

    public function setIlluminantName(?string $name) : parent {
        $this->illuminantName = $name;
        return $this;
    }
}
