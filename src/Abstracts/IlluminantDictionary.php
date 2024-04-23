<?php

namespace tei187\ColorTools\Abstracts;

use tei187\ColorTools\Illuminants\Illuminant;
use tei187\ColorTools\Interfaces\IlluminantDictionary as IlluminantDictionaryInterface;
use tei187\ColorTools\Math\ModelConversion;

/**
 * Abstract class for creating custom illuminant dictionaries.
 * For proper use, requires at least (x,y) white point constans dictionary
 * (refer to `tei187\ColorTools\StandardIlluminants\WhitePoint2`)
 */
abstract class IlluminantDictionary implements IlluminantDictionaryInterface {

    /**
     * Array of names corresponding to illuminants defined by this dictionary.
     * 
     * @var string[]
     */
    const INDEX = self::INDEX;
    
/**
     * Defines the standard observer angles (in degrees) for which the white point
     * and tristimulus values are defined in this dictionary.
     * 
     * If any of the methods requires a specific angle and it is not being passed,
     * the first item in the list will be used as default.
     * 
     * @var int[]
     */ 
    const ANGLES = self::ANGLES;

    /**
     * Namespace for (x,y) white point constans values defined by this dictionary
     * (without the degree interger at the end).
     * 
     * @var string
     */
    const WHITEPOINT = self::WHITEPOINT;

    /**
     * Tries to assess if the passed argument is a reference of a standard
     * illuminant available in the dictionary.
     *
     * @param string $name Name of the standard illuminant.
     * @return string|false Returns the illuminant name if assessed properly, otherwise returns boolean false.
     */
    public static function assessStandardIlluminant(string $name)
    {
        $as = "";
        if (is_string($name) && strlen(trim($name)) > 0) {
            $name = explode("|", $name)[0];
            if (array_search(strtoupper(trim($name)), static::INDEX) === false) {
                return false;
            } else {
                $as = strtoupper(trim($name));
            }
        }

        return
            $as !== ""
            ? $as
            : false;
    }

    /**
     * Checks the provided string and returns an array with the standard illuminant
     * name and optional parameter.
     *
     * @param string $s The input string to be checked.
     * @return array An array containing the standard illuminant name (index 0) and optional parameter (index 1), or null values if the input is invalid.
     */
    private static function _checkString(string $s): array
    {
        $out = [];
        $e = explode("|", $s);
        $out[0] = array_search(strtoupper(trim($e[0])), static::INDEX) !== false
                ? strtoupper(trim($e[0]))
                : null;
        $out[1] = isset($e[1]) && in_array($e[1], static::ANGLES)
                ? $e[1]
                : null;

        return $out;
    }

    /**
     * Retrieves a constant value from the `StandardIlluminants\WhitePoint{angle}`
     * class based on the provided name and angle.
     *
     * @param string $name The name of the standard illuminant.
     * @param integer $angle The angle of the standard illuminant (2 or 10).
     * @return array The constant value.
     * @throws \Exception If the constant is not found.
     */
    static function _retrieveConst(string $name, ?int $angle = null) {
        is_null($angle) ? $angle = static::ANGLES[0] : null;

        $check = self::_checkString($name);
        if ($check[0] === null) {
            $check = null;
        } else {
            $name = $check[0];
            $angle = $check[1] === null
                ? (in_array($angle, static::ANGLES) ? $angle : static::ANGLES[0])
                : $check[1];
            $check = constant(static::WHITEPOINT . $angle . "::" . strtoupper(trim($name)));
        }

        return is_null($check) 
            ? throw new \Exception("Illuminant not found in dictionary: ". $name. " @ ". $angle."deg")
            : $check;
    }

    /**
     * Attempts to retrieve the chromatic coordinates of the white point for the
     * specified standard illuminant name and angle.
     *
     * @param string $name The name of the standard illuminant, e.g. "D65", "A", "F11".
     * @param int $angle The angle of the standard illuminant, typically 2 or 10 degrees. Defaults to 2 degrees if not provided.
     * @return array|false An array containing the chromatic coordinates, or false if the input is invalid or the coordinates could not be retrieved.
     */
    public static function getChromaticCoordinates(string $name, ?int $angle = null)
    {
        is_null($angle) ? $angle = static::ANGLES[0] : null;
        return self::_retrieveConst($name, $angle);
    }

    /**
     * Attempts to retrieve the tristimulus values (X, Y, Z) of the white point
     * for the specified illuminant name and angle.
     *
     * @param string $name The name of the illuminant.
     * @param int $angle The angle of the illuminant, typically 2 or 10.
     * @return array|false The tristimulus values as an array, or false if the values could not be retrieved.
     */
    public static function getTristimulus(string $name, ?int $angle = null)
    {
        is_null($angle) ? $angle = static::ANGLES[0] : null;

        $xy = self::_retrieveConst($name, $angle);
        if ($xy !== false) {
            return ModelConversion::chromaticity_to_tristimulus($xy);
        }
        return false;
    }

    /**
     * Looks up the illuminant object for the specified name and angle and returns as Illuminant if found.
     *
     * @param string $name The name of the standard illuminant, e.g. "D65", "A", "F11".
     * @param int $angle The angle of the standard illuminant, typically 2 or 10 degrees. Defaults to 2 degrees if not provided.
     * @return Illuminant Returns illuminant if found in dictionary.
     */   
    public static function getIlluminant(string $name, ?int $angle = null): Illuminant {
        return new Illuminant(self::getChromaticCoordinates($name, $angle), $angle, $name);
    }

    public static function index(): array {
        return static::INDEX;
    }
}