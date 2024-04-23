<?php

namespace tei187\ColorTools\Interfaces;

/**
 * Interface for measure/swatch methods.
 */
interface Measure {
    /**
     * Sets the values for the measure/swatch.
     *
     * @param mixed ...$values The values to set.
     */
    public function setValues(...$values);

    /**
     * Returns the values for the measure/swatch.
     *
     * @return mixed The values.
     */
    public function getValues();

    /**
     * Converts the measure/swatch to the XYZ color space.
     *
     * @return mixed The XYZ values.
     */
    public function toXYZ();

    /**
     * Converts the measure/swatch to the xyY color space.
     *
     * @return mixed The xyY values.
     */
    public function toxyY();

    /**
     * Converts the measure/swatch to the Lab color space.
     *
     * @return mixed The Lab values.
     */
    public function toLab();

    /**
     * Converts the measure/swatch to the LCh color space.
     *
     * @return mixed The LCh values.
     */
    public function toLCh();

    /**
     * Converts the measure/swatch to the Luv color space.
     *
     * @return mixed The Luv values.
     */
    public function toLuv();

    /**
     * Converts the measure/swatch to the LCh_uv color space.
     *
     * @return mixed The LCh_uv values.
     */
    public function toLCh_uv();

    /**
     * Converts the measure/swatch to the HSL color space.
     *
     * @return mixed The HSL values.
     */
    public function toHSL();

    /**
     * Converts the measure/swatch to the HSV color space.
     *
     * @return mixed The HSV values.
     */
    public function toHSV();

    /**
     * Converts the measure/swatch to the RGB color space.
     *
     * @return mixed The RGB values.
     */
    public function toRGB();

    /**
     * Converts the measure/swatch to the specified color space.
     *
     * @param string $class The class to convert to.
     * @param string $primaries The primaries to use for the conversion.
     * @return mixed The converted values.
     */
    public function to($class, $primaries = 'sRGB');

    /**
     * Returns the temperature of the measure/swatch.
     *
     * @return mixed The temperature.
     */
    public function getTemperature();
}
