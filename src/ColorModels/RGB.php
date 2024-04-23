<?php

namespace tei187\ColorTools\ColorModels;

use tei187\ColorTools\Math\ModelConversion;
use tei187\ColorTools\Abstracts\DeviceDependent as DeviceDependentAbstract;

class RGB extends DeviceDependentAbstract {
    /**
     * Creates a RGB swatch.
     * 
     * @param string|array $values Array with RGB values in one of the forms: 
     * * array with 3 arithmetic values ranging from 0 to 1 (float),
     * * array with 3 integer values ranging from 0 to 255
     * * string with hexadecimal representation of 3 values (`'#rrggbb'` or `'#rgb'`).
     * @param object|string $primaries RGB primaries object of tei187\ColorTools\Conversion\RGBPrimaries namespace or string corresponding to available primaries name/identifier.
     */
    public function __construct($values = [0,0,0], $primaries = 'sRGB') {
        $this->_setValuesKeys('RGB');
        $this->setValues($values);
        $this->setPrimaries($primaries);
    }

    public function toXYZ(): XYZ {
        //$outcome = ModelConversion::RGB_to_XYZ($this->getValues(), $this->primaries);
        //return (new XYZ($outcome))->setIlluminant($this->illuminant);
        return new XYZ(
            ModelConversion::RGB_to_XYZ(
                $this->getValues(),
                $this->primaries
            ),
            $this->getIlluminant()
        );
    }

    public function toxyY(): xyY {
        //$outcome = ModelConversion::RGB_to_xyY($this->getValues(), $this->primaries);
        //return (new xyY($outcome))->setIlluminant($this->illuminant);
        return new xyY(
            ModelConversion::RGB_to_xyY(
                $this->getValues(),
                $this->primaries
            ),
            $this->getIlluminant()
        );
    }

    public function toLab(): Lab {
        //$outcome = ModelConversion::RGB_to_Lab($this->getValues(), $this->primaries);
        //return (new Lab($outcome))->setIlluminant($this->illuminant);
        return new Lab(
            ModelConversion::RGB_to_Lab(
                $this->getValues(),
                $this->primaries
            ),
            $this->getIlluminant()
        );
    }

    public function toLCh(): LCh {
        //$outcome = ModelConversion::RGB_to_LCh($this->getValues(), $this->primaries);
        //return (new LCh($outcome))->setIlluminant($this->illuminant);
        return new LCh(
            ModelConversion::RGB_to_LCh(
                $this->getValues(),
                $this->primaries
            ),
            $this->getIlluminant()
        );
    }

    public function toLuv(): Luv {
        //$outcome = ModelConversion::RGB_to_Luv($this->getValues(), $this->primaries);
        //return (new Luv($outcome))->setIlluminant($this->illuminant);
        return new Luv(
            ModelConversion::RGB_to_Luv(
                $this->getValues(),
                $this->primaries
            ),
            $this->getIlluminant()
        );
    }

    public function toHSL($primaries = null): HSL {
        //$outcome = ModelConversion::RGB_to_HSL($this->getValues());
        //return (new HSL($outcome))->setPrimaries($this->primaries)->setIlluminant($this->illuminant);
        return new HSL(
            ModelConversion::RGB_to_HSL(
                $this->getValues(),
                $this->primaries
            ),
            $this->primaries
        );
    }

    public function toLCh_uv(): LCh_uv {
        //$outcome = ModelConversion::RGB_to_LCh_uv($this->getValues(), $this->primaries);
        //return (new LCh_uv($outcome))->setIlluminant($this->illuminant);
        return new LCh_uv(
            ModelConversion::RGB_to_LCh_uv(
                $this->getValues(),
                $this->primaries
            ),
            $this->getIlluminant()
        );
    }

    public function toRGB($primaries = null): RGB {
        return $this;
    }

    public function toHSV($primaries = 'sRGB') : HSV {
        //$outcome = ModelConversion::RGB_to_HSV($this->getValues());
        //return (new HSV($outcome))->setPrimaries($this->primaries)->setIlluminant($this->illuminant);
        return new HSV(
            ModelConversion::RGB_to_HSV(
                $this->getValues(),
                $this->primaries
            ),
            $this->primaries
        );
    }

    /**
     * Returns RGB values in hex form.
     *
     * @param boolean $asString Boolean switch. If true, returns a string in '#RRGGBB' formatting. If false, returns an array with RGB keys.
     * @return array|string
     */
    public function getValuesHex(bool $asString = false) {
        list($R, $G, $B) = array_values($this->getValuesFF());
        if(!$asString) {
            return [
                'R' => str_pad(dechex($R), 2, "0", STR_PAD_LEFT),
                'G' => str_pad(dechex($G), 2, "0", STR_PAD_LEFT),
                'B' => str_pad(dechex($B), 2, "0", STR_PAD_LEFT) 
            ];
        }
        return "#".str_pad(dechex($R), 2, "0", STR_PAD_LEFT).str_pad(dechex($G), 2, "0", STR_PAD_LEFT).str_pad(dechex($B), 2, "0", STR_PAD_LEFT);
    }

    /**
     * Returns RGB values array in integer form, from 0 to 255.
     *
     * @return array
     */
    public function getValuesFF() : array {
        list($R, $G, $B) = array_values($this->getValues());
        return [
            'R' => intval(round($R * 255)),
            'G' => intval(round($G * 255)),
            'B' => intval(round($B * 255))
        ];
    }

    /**
     * Returns RGB values array in string form, formatting as "rgb(R,G,B)".
     *
     * @return string
     */
    public function getValuesString() : string {
        list($R, $G, $B) = array_values($this->getValuesFF());
        return "rgb({$R},{$G},{$B})";
    }
}