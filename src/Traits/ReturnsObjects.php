<?php

namespace tei187\ColorTools\Traits;

use tei187\ColorTools\Measures\XYZ;
use tei187\ColorTools\Measures\Lab;
use tei187\ColorTools\Measures\LCh;
use tei187\ColorTools\Measures\LCh_uv;
use tei187\ColorTools\Measures\Luv;
use tei187\ColorTools\Measures\xyY;

/**
 * @deprecated
 */
trait ReturnsObjects {
    /*private function _set($obj, $data, $illuminant) {
        return $obj
            ->setValues($data)
            ->setIlluminant($illuminant);
    }*/

    private function returnAsLab($data) : Lab {
        return new Lab($data, $this->illuminant);
    }

    private function returnAsXYZ($data) : XYZ {
        return new XYZ($data, $this->illuminant);
    }

    private function returnAsLCh($data) : LCh {
        return new LCh($data, $this->illuminant);
    }

    private function returnAsxyY($data) : xyY {
        return new xyY($data, $this->illuminant);
    }

    private function returnAsLuv($data) : Luv {
        return new Luv($data, $this->illuminant);
    }

    private function returnAsLCh_uv($data) : LCh_uv {
        return new LCh_uv($data, $this->illuminant);
    }
 }