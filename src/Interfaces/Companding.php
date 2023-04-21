<?php

namespace tei187\ColorTools\Interfaces;

/**
 * Interface for gamma companding types.
 */
interface Companding {
    public function applyCompanding(...$args);
    public function applyInverseCompanding(...$args);
}