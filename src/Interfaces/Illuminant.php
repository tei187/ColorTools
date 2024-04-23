<?php

namespace tei187\ColorTools\Interfaces;

use tei187\ColorTools\Dictionaries\Illuminants\Standard\Dictionary;

/**
 * Defines an interface for an illuminant, which represents a light source that can be used to calculate color values.
 *
 * The illuminant is defined by its white point (x, y coordinates) and its measurement angle.
 * The interface provides methods to get and set the illuminant's properties, as well as to create new illuminants.
 */
interface Illuminant
{
    public function __construct(array $xy = [], int $angle = 2, ?string $name = null);

    // static
    static function from(string $name, int $angle = 2, IlluminantDictionary $dictionary = new Dictionary): ?Illuminant;
    static function make(array $values = [], ?int $angle = 2, ?string $name = null): ?Illuminant;

    // getters
    public function get(string $attribute, bool $indexed);
    public function getAngle(): int;
    public function getName(): ?string;
    public function getWhitePoint(): array;
    public function getTristimulus(): array;

    // setters
    public function set(string $attribute, $value): self;
    public function setAngle(int $angle): self;
    public function setName(?string $name): self;
    public function setWhitePoint(array $xy): self;
    public function setTristimulus(array $xyz): self;
}
