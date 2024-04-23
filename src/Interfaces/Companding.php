<?php

namespace tei187\ColorTools\Interfaces;

/**
 * Interface for gamma companding types.
 */
interface Companding {
    /**
     * Applies the companding transformation to the provided arguments.
     *
     * @param mixed ...$args The arguments to apply the companding transformation to.
     * @return mixed The transformed arguments.
     */
    public function applyCompanding(...$args);

    /**
     * Applies the inverse companding transformation to the provided arguments.
     *
     * @param mixed ...$args The arguments to apply the inverse companding transformation to.
     * @return mixed The transformed arguments.
     */
    public function applyInverseCompanding(...$args);
}