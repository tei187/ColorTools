<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\Convert;

class RGB extends RGBMeasureAbstract {

    public function getTemperature() {
        return "temperature";
    }

    /**
     * Will return XYZ values in the same illuminant as default for specified RGB primaries set. If another is required, use chromatic adaptation methods.
     *
     * @return XYZ
     */
    public function toXYZ(): XYZ {
        $outcome = Convert::RGB_to_XYZ($this->getValues(), $this->primaries);
        return
            (new XYZ($outcome['values']))
                ->setIlluminantName($outcome['illuminantName'])
                ->setIlluminantTristimulus($outcome['illuminantTristimulus']);
    }

    public function toxyY(): xyY {
        return new xyY;
    }

    public function toLab(): Lab {
        return new Lab;
    }

    public function toLCh(): Lch {
        return new LCh;
    }

    public function toLuv(): Luv {
        return new Luv;
    }

    public function toLCh_uv(): LCh_uv {
        return new LCh_uv;
    }

    public function toRGB(): RGB {
        return $this;
    }
}