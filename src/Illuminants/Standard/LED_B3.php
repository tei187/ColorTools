<?php

namespace tei187\ColorTools\Illuminants\Standard;

use tei187\ColorTools\Interfaces\StandardIlluminant as StandardIlluminantInterface;
use tei187\ColorTools\Traits\StandardIlluminant;
use tei187\ColorTools\Traits\IsStandardIlluminant;

readonly class LED_B3 implements StandardIlluminantInterface {
    use IsStandardIlluminant,
        StandardIlluminant;
}