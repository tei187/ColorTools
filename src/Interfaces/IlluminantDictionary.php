<?php

namespace tei187\ColorTools\Interfaces;

/**
 * Provides an interface for accessing information about standard illuminants.
 *
 * The IlluminantDictionary interface defines a set of static methods for retrieving
 * information about standard illuminants, such as their chromatic coordinates,
 * tristimulus values, and the ability to create an Illuminant object representing
 * the illuminant.
 *
 * The methods in this interface allow you to:
 * - Assess the name of a standard illuminant
 * - Retrieve constant values associated with an illuminant
 * - Get the chromatic coordinates of an illuminant
 * - Get the tristimulus values of an illuminant
 * - Create an Illuminant object representing a standard illuminant
 */
interface IlluminantDictionary
{
public static function assessStandardIlluminant(string $name);
public static function _retrieveConst(string $name, int $angle = 2);
public static function getChromaticCoordinates(string $name, int $angle = 2);
public static function getTristimulus(string $name, int $angle = 2);
public static function getIlluminant(string $name, int $angle = 2): \tei187\ColorTools\Interfaces\Illuminant;
}
