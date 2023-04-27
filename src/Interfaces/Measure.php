<?php

namespace tei187\ColorTools\Interfaces;

/**
 * Interface for measure/swatch methods.
 */
interface Measure {
    public function setValues(...$values);
    public function getValues();

    public function toXYZ();
    public function toxyY();
    public function toLab();
    public function toLCh();
    public function toLuv();
    public function toLCh_uv();
    public function toHSL();
    public function toHSV();
    public function toRGB();
    public function to($class, $primaries = 'sRGB');

    public function getTemperature();
}
