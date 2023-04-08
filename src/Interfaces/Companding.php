<?php

namespace tei187\ColorTools\Interfaces;

interface Companding {
    public function applyCompanding(...$args);
    public function applyInverseCompanding(...$args);
}