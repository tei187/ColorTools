<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Dictionaries\Illuminants\Standard\Dictionary;
use tei187\ColorTools\Interfaces\IlluminantDictionary;
use tei187\ColorTools\Illuminants\Illuminant;

/**
 * Trait handling illuminant-oriented properties and methods.
 * 
 */
trait UsesIlluminant {
    /**
     * Property holding illuminant object.
     *
     * @var Illuminant
     */
    public $illuminant;

    /**
     * Sets values and angle of illuminant used during measurement.
     *
     * @param string|array|Illuminant $illuminant The illuminant to use. Can be a string (e.g. 'D65'), an array of (x, y) chromacity values, an array of (X, Y, Z) tristimulus values, or an Illuminant object.
     * @param int $angle The angle of the illuminant, typically 2 or 10 degrees. Ommited if `$illuminant` is a Illuminant class object.
     * @param string $name The name of the custom illuminant. Ommited if `$illuminant` is a Illuminant class object.
     * @param IlluminantDictionary $dictionary The dictionary to use for looking up illuminant data. By default uses standard illuminant dictionary.
     * @return $this
     * @throws \Exception If the illuminant is not found in the dictionary.
     * @throws \InvalidArgumentException If the input array for the illuminant does not match the expected format.
     * @throws \Error If the input for the illuminant is not a valid string, array, or Illuminant object.
     */
    public function setIlluminant($illuminant = 'D65', int $angle = 2, string $name = 'CUSTOM', IlluminantDictionary $dictionary = new Dictionary)
    {
        if (is_string($illuminant)) {
            $data = constant(get_class($dictionary)::WHITEPOINT . $angle . "::" . strtoupper(trim($illuminant)));
            if ($data !== null) {
                // return from dictionary
                $this->illuminant = Illuminant::from($illuminant, $angle);
            } else {
                // not in dictionary
                throw new \Exception("Illuminant of \"" . $illuminant . "\" not found in dictionary " . get_class($dictionary) . ".");
                return false;
            }
        } elseif (is_array($illuminant)) {
            switch (count($illuminant)) {
                case 2:
                    // from XY chromacity
                    $this->illuminant = Illuminant::make(array_values($illuminant), $angle, $name);
                    break;
                case 3:
                    // from XYZ tristimulus
                    $this->illuminant = new Illuminant([0, 0], $angle, $name);
                    $this->illuminant->setTristimulus(array_values($illuminant));
                    break;
                default:
                    // wrong input
                    throw new \InvalidArgumentException('Wrong input for illuminant. Array does not match any of the accepted formats (xy or XYZ).');
                    break;
            }
        } elseif (is_object($illuminant) && $illuminant instanceof Illuminant) {
            $this->illuminant = $illuminant;
        } else {
            throw new \Error('Wrong input for illuminant. Must be a valid string, array of (x,y) or (X,Y,Z), or Illuminant object.');
        }
        return $this;
    }
}
