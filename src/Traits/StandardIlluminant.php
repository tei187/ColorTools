<?php

namespace tei187\ColorTools\Traits;

/**
 * Represents a standard illuminant, which is a theoretical light source used in color science.
 * Standard illuminants are defined by their spectral power distribution and are used as a reference
 * for calculating color values.
 *
 * This class provides methods for constructing an Illuminant object with the given white point coordinates,
 * angle, and name, as well as a static method for creating an Illuminant instance from a name and angle
 * if it exists in the dictionary.
 */
trait StandardIlluminant {
    /**
     * The angle of the standard illuminant, in degrees.
     */
    readonly int $angle;
    /**
     * The name of the standard illuminant.
     */
    readonly string $name;
    /**
     * The white point XY coordinates of the standard illuminant.
     */
    readonly array $whitepoint;
    /**
     * The tristimulus XYZ values of the standard illuminant.
     */
    readonly array $tristimulus;
    
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

    function __get($name) {
        if(property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \InvalidArgumentException('Unknown property: '. $name);
        }
    }
}
