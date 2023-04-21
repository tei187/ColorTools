<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\RGBPrimaries\Standard\sRGB;
use tei187\ColorTools\Helpers\ArrayMethods;
use tei187\ColorTools\Traits\Illuminants;
use tei187\ColorTools\Traits\PrimariesLoader;
use tei187\ColorTools\Measures\MeasureAbstract;

abstract class RGBMeasureAbstract extends MeasureAbstract {
    use Illuminants,
        PrimariesLoader;

    /**
     * RGB values.
     *
     * @var array
     */
    protected $values = [
        'R' => 0,
        'G' => 0,
        'B' => 0
    ];
    /**
     * Specific RGB primaries.
     *
     * @var object Object with primaries, based on \tei187\ColorTools\Interfaces\Primaries interface and \tei187\ColorTools\Conversion\RGBPrimaries\PrimariesAbstract abstract class.
     */
    protected $primaries;

    /**
     * @param string|array $values Array with RGB values in one of the forms: 
     * * array with 3 arithmetic values ranging from 0 to 1 (float),
     * * array with 3 integer values ranging from 0 to 255
     * * string with hexadecimal representation of 3 values (`'#rrggbb'` or `'#rgb'`).
     * @param object|string $primaries RGB primaries object of tei187\ColorTools\Conversion\RGBPrimaries namespace or string corresponding to available primaries name/identifier.
     */
    public function __construct($values = [0,0,0], $primaries = 'sRGB') {
        $this->_setValuesKeys('RGB');
        $this->setValues($values);

        $assessedPrimaries = $this->loadPrimaries($primaries);
        
        $this->primaries =
            $assessedPrimaries === false
                ? new sRGB
                : $assessedPrimaries;
        $this->setIlluminant($this->primaries->getIlluminantName(), 2);
        $this->illuminantT = $this->primaries->getIlluminantTristimulus();
    }

    public function getPrimaries() : object {
        return $this->primaries;
    }

    /**
     * Sets values for object.
     *
     * @param array|string $values Treats string as hexadecimal transcription of RGB (#rgb or #rrggbb)
     * @return self If input values are incorrect and do not fall under any interpretation, sets values as rgb(0,0,0).
     */
    public function setValues(...$values) : self {
        if(count($values) == 1) {
            $values = $values[0];
            if(is_string($values)) {
                $t = str_replace(["#", " "], "", trim($values));
                $t_l = strlen($t);
                if(ctype_xdigit($t)) {
                    if($t_l == 3 || $t_l == 4) {
                        $this->values = 
                            [
                                'R' => hexdec($t[0].$t[0]) / 255,
                                'G' => hexdec($t[1].$t[1]) / 255,
                                'B' => hexdec($t[2].$t[2]) / 255
                            ];
                    } elseif($t_l == 6 || $t_l == 8) {
                        $this->values = 
                            [
                                'R' => hexdec($t[0].$t[1]) / 255,
                                'G' => hexdec($t[2].$t[3]) / 255,
                                'B' => hexdec($t[4].$t[5]) / 255
                            ];
                    } else {
                        $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                    }
                } else {
                    $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                }
            } elseif ( is_array($values) ) {
                if(count($values) == 3) {
                    if(ArrayMethods::itemsBetween0and1($values)) {
                        $values = array_values($values);
                        $this->values = [
                            'R' => $values[0],
                            'G' => $values[1],
                            'B' => $values[2]
                        ];
                    } elseif(ArrayMethods::itemsBetween0and255($values)) {
                        $values = array_values($values);
                        $this->values = [
                            'R' => $values[0] / 255,
                            'G' => $values[1] / 255,
                            'B' => $values[2] / 255
                        ];
                    } else {
                        $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                    }
                } else {
                    $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
                }
            } else {
                $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
            }
        } elseif(count($values) == 3) {
            if(ArrayMethods::itemsBetween0and1($values)) {
                $values = array_values($values);
                $this->values = [
                    'R' => $values[0],
                    'G' => $values[1],
                    'B' => $values[2]
                ];
            } elseif(ArrayMethods::itemsBetween0and255($values)) {
                $values = array_values($values);
                $this->values = [
                    'R' => $values[0] / 255,
                    'G' => $values[1] / 255,
                    'B' => $values[2] / 255
                ];
            } else {
                $this->values = [ 'R' => 0, 'G' => 0, 'B' => 0 ];
            }
        }
        return $this;
    }

    /**
     * Converts from RGB to XYZ values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return XYZ
     */
    abstract public function toXYZ(): XYZ;
    /**
     * Converts from RGB to xyY values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return xyY
     */
    abstract public function toxyY(): xyY;
    /**
     * Converts from RGB to L\*a\*b values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return Lab
     */
    abstract public function toLab(): Lab;
    /**
     * Converts from RGB to L\*C\*h values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return LCh
     */
    abstract public function toLCh(): LCh;
    /**
     * Converts from RGB to LChUV values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return LCh_uv
     */
    abstract public function toLCh_uv(): LCh_uv;
    /**
     * Converts from RGB to Luv values in the same illuminant as default for specified RGB primaries set. If another destination illuminant is required, use chromatic adaptation methods.
     *
     * @return Luv
     */
    abstract public function toLuv(): Luv;
    abstract public function toRGB($primaries = 'sRGB'): RGB;

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