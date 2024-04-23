<?php

namespace tei187\ColorTools\Illuminants;

use tei187\ColorTools\Interfaces\Illuminant as IlluminantInterface;
use tei187\ColorTools\Math\ModelConversion;
use tei187\ColorTools\Interfaces\IlluminantDictionary;
use tei187\ColorTools\Dictionaries\Illuminants\Standard\Dictionary;

/**
 * Represents a standard illuminant, which is a theoretical light source used in color science.
 * Standard illuminants are defined by their spectral power distribution and are used as a reference
 * for calculating color values.
 *
 * This class provides methods for constructing an Illuminant object with the given white point coordinates,
 * angle, and name, as well as a static method for creating an Illuminant instance from a name and angle
 * if it exists in the dictionary.
 */
class Illuminant implements IlluminantInterface
{
    /**
     * The angle of the standard illuminant, in degrees.
     */
    protected $angle = 2;
    /**
     * The name of the standard illuminant.
     */
    protected $name;
    /**
     * The white point XY coordinates of the standard illuminant.
     */
    protected $whitepoint = [];
    /**
     * The tristimulus XYZ values of the standard illuminant.
     */
    protected $tristimulus = [];

    /**
     * Constructs an Illuminant object with the given white point coordinates, angle, and name.
     *
     * @param array $xy The (x, y) chromaticity coordinates of the white point.
     * @param int $angle The angle of the illuminant, typically 2 or 10 degrees.
     * @param string|null $name The name of the illuminant, or null if no name is provided.
     */
    public function __construct(array $xy = [], int $angle = 2, ?string $name = null) {
        $this->whitepoint = $xy;
        $this->tristimulus = ModelConversion::chromaticity_to_tristimulus($xy);
        $this->angle = $angle;
        $this->name = is_null($name) ? "CUSTOM" : strtoupper(trim($name));
    }

// STATIC METHODS

    /**
     * Creates a new Illuminant instance from the provided name and angle if it exists in dictionary. If the name does exist but angle does not, it will default to 2 degrees angle.
     *
     * @param string|null $name The name of the illuminant.
     * @param int|null $angle The angle of the illuminant. If not provided, the default angle of 2 will be used.
     * @param IlluminantDictionary $dictionary The dictionary to search for the illuminant. 
     * @return Illuminant|null The created Illuminant instance, or null if the illuminant could not be found.
     * @throws \InvalidArgumentException If the passed angle is not 2 or 10 degrees.
     * @throws \InvalidArgumentException If the passed illuminant name (corellated with the angle) cannot be found in standard illuminant dictionary.
     */
    static function from(?string $name = null, ?int $angle = 2, IlluminantDictionary $dictionary = new Dictionary): ?Illuminant {
        if(!in_array($angle, $dictionary::ANGLES)) {
            throw new \InvalidArgumentException("Invalid angle (standard illuminants described ".implode(", ", $dictionary::ANGLES)." degrees): ". $angle);
        }

        $data = Dictionary::_retrieveConst($name, $angle);
        if ($data !== false) {
            $data = array_values($data);
            return new self([$data[0], $data[1]], $angle, $name);
        }
        throw new \InvalidArgumentException("Standard illuminant not found in dictionary: ". $name. " @ ". $angle. " degrees.");
        return null;
    }

    /**
     * Creates a new Illuminant instance based on the provided input values.
     *
     * If the input array has 2 elements, it is assumed to be the (x, y) chromaticity coordinates of the white point, and a new Illuminant instance is created using those values.
     *
     * If the input array has 3 elements, it is assumed to be the tristimulus XYZ values, and a new Illuminant instance is created using the converted chromaticity coordinates.
     *
     * @param array $values The input values, either a 2-element array of (x, y) chromaticity coordinates or a 3-element array of tristimulus XYZ values.
     * @param int|null $angle The angle of the illuminant, typically 2 or 10 degrees. If not provided, the default angle of 2 degrees will be used.
     * @param string|null $name The name of the illuminant. If not provided, no name will be set.
     * @return Illuminant|null The created Illuminant instance, or false if the input values are invalid.
     */
    static function make(array $values = [], ?int $angle = 2, ?string $name = null): ?Illuminant {
        $illuminant = null;
        switch (count($values)) {
            case 2: // whitepoint
                $illuminant = new Illuminant(array_values($values), $angle, $name);
                break;
            case 3: // tristimulus
                $illuminant = (new Illuminant(ModelConversion::tristimulus_to_chromaticity($values), $angle, $name))->setTristimulus($values);
                break;
            default: // unknown
                throw new \InvalidArgumentException("Invalid input values for creating an Illuminant instance (wrong length): ". json_encode($values));
                $illuminant = null;
        }
        return $illuminant;
    }
    

// SETTERS

    /**
     * Sets the specified attribute of the Illuminant instance to the given value.
     *
     * Supported attributes are:
     * - 'name': Sets the name of the standard illuminant.
     * - 'angle': Sets the angle of the standard illuminant.
     * - 'whitepoint': Sets the white point chromaticity coordinates of the standard illuminant.
     * - 'tristimulus': Sets the tristimulus XYZ values of the standard illuminant.
     *
     * @param string $attribute The name of the attribute to set.
     * @param mixed $value The new value to set for the specified attribute.
     * @return $this The current Illuminant instance, for method chaining.
     * @throws \InvalidArgumentException If the specified attribute is unknown.
     */
    public function set(string $attribute, $value): self {
        switch ($attribute) {
            case 'name':
                $this->setName($value);
                break;
            case 'angle':
                $this->setAngle($value);
                break;
            case 'whitepoint':
                $this->setWhitepoint($value);
                break;
            case 'tristimulus':
                $this->setTristimulus($value);
                break;
            default:            
                throw new \InvalidArgumentException('Unknown attribute: '. $attribute .'. This method only supports the following attributes: name, angle, whitepoint, tristimulus.');
        }
        return $this;
    }

    /**
     * Sets the tristimulus XYZ values of the standard illuminant (and converts the chromaticity coordinates).
     *
     * @param array $xyz The new tristimulus XYZ values to set.
     * @return $this The current Illuminant instance, for method chaining.
     */
    public function setTristimulus(array $xyz): self
    {
        $this->tristimulus = array_values($xyz);
        $this->whitepoint = ModelConversion::tristimulus_to_chromaticity($xyz);
        return $this;
    }

    /**
     * Sets the white point chromaticity coordinates of the standard illuminant (and converts the tristimulus XYZ values)..
     *
     * @param array $xy The new (x, y) chromaticity coordinates to set.
     * @return $this The current Illuminant instance, for method chaining.
     */
    public function setWhitepoint(array $xy): self
    {
        $this->whitepoint = array_values($xy);
        $this->tristimulus = ModelConversion::chromaticity_to_tristimulus($xy);
        return $this;
    }

    /**
     * Sets the angle of the standard illuminant.
     *
     * @param int $angle The new angle to set for the illuminant.
     * @return $this The current Illuminant instance, for method chaining.
     */
    public function setAngle(int $angle): self
    {
        $this->angle = $angle;
        return $this;
    }

    /**
     * Sets the name of the standard illuminant.
     *
     * @param ?string $name The new name to set for the illuminant, or null to clear the name.
     * @return $this The current Illuminant instance, for method chaining.
     */
    public function setName(?string $name): self
    {
        $this->name = strtoupper(trim($name));
        return $this;
    }
    
// GETTERS

    /**
     * Get the specified attribute of the illuminant.
     *
     * @param string $attribute The attribute to retrieve. Can be one of the following:
     *                               - 'name' (string): The name of the illuminant.
     *                               - 'angle' (float): The correlated color temperature angle of the illuminant.
     *                               - 'whitepoint' (array): The XYZ whitepoint values of the illuminant.
     *                               - 'tristimulus' (array): The XYZ tristimulus values of the illuminant.
     * @param bool $indexed Whether to return the whitepoint or tristimulus values as an indexed array (true)
     *                      or an associative array (false). This parameter is only relevant when requesting
     *                      the 'whitepoint' or 'tristimulus' attributes.
     *
     * @return mixed The requested attribute value.
     * @throws \InvalidArgumentException If the specified attribute is unknown.
     *
     * Examples:
     * - `$illuminant->get('name')` returns the name of the illuminant (e.g., 'D65').
     * - `$illuminant->get('angle')` returns the measurement angle (e.g., 2).
     * - `$illuminant->get('whitepoint')` returns an associative array with the XYZ whitepoint values (e.g., ['x' => 0.95047, 'y' => 1.0]).
     * - `$illuminant->get('whitepoint', true)` returns an indexed array with the XYZ whitepoint values (e.g., [0.95047, 1.0]).
     * - `$illuminant->get('tristimulus')` returns an associative array with the XYZ tristimulus values (e.g., ['x' => 0.95047, 'y' => 1.0, 'z' => 1.08883]).
     * - `$illuminant->get('tristimulus', true)` returns an indexed array with the XYZ tristimulus values (e.g., [0.95047, 1.0, 1.08883]).
     */
    public function get(string $attribute, bool $indexed = false) {
        switch($attribute) {
            case 'name':
                return $this->getName();
            case 'angle':
                return $this->getAngle();
            case 'whitepoint':
                return $this->getWhitepoint($indexed);
            case 'tristimulus':
                return $this->getTristimulus($indexed);
            default:
                throw new \InvalidArgumentException('Unknown attribute: '. $attribute);
        }
    }

    /**
     * Gets the tristimulus XYZ values of the standard illuminant.
     *
     * @param bool $indexed If true, the returned array will be indexed with the keys 'x', 'y', and 'z'. Otherwise, the array will contain the values in the order [x, y, z].
     * @return array The tristimulus XYZ values of the standard illuminant.
     */
    public function getTristimulus(bool $indexed = false): array
    {
        return $indexed
            ? array_combine(['x', 'y', 'z'], $this->tristimulus)
            : array_values($this->tristimulus);
    }

    /**
     * Gets the (x, y) chromaticity coordinates of the standard illuminant's white point.
     *
     * @param bool $indexed If true, the returned array will be indexed with the keys 'x' and 'y'. Otherwise, the array will contain the values in the order [x, y].
     * @return array The (x, y) chromaticity coordinates of the standard illuminant's white point.
     */
    public function getWhitepoint(bool $indexed = false): array
    {
        return $indexed
            ? array_combine(['x', 'y'], $this->whitepoint)
            : array_values($this->whitepoint);
    }

    /**
     * Gets the angle of the standard illuminant.
     *
     * @return int The angle of the standard illuminant.
     */
    public function getAngle(): int
    {
        return $this->angle;
    }

    /**
     * Gets the name of the standard illuminant.
     *
     * @return ?string The name of the standard illuminant, or null if no name is set.
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
