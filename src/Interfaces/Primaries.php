<?php

namespace tei187\ColorTools\Interfaces;

interface Primaries {
    public function getPrimariesXYY() : array;
    public function getPrimariesName() : ?string;
    public function getIlluminantName() : ?string;
    public function getIlluminantTristimulus() : array;
    public function getGamma();
}