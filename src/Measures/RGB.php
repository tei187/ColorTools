<?php

namespace tei187\ColorTools\Measures;

use tei187\ColorTools\Conversion\Convert;

class RGB extends RGBMeasureAbstract {
    /**
     * Will return XYZ values in the same illuminant as default for specified RGB primaries set. If another is required, use chromatic adaptation methods.
     *
     * @return XYZ
     */
    public function toXYZ(): XYZ {
        $outcome = Convert::RGB_to_XYZ($this->getValues(), $this->primaries);
        return
            (new XYZ($outcome))
                ->setIlluminant($this->getIlluminantName(), 2)
                ->setIlluminantName($this->getIlluminantName())
                ->setIlluminantTristimulus(Convert::XYZ_to_xy($this->getIlluminantTristimulus()));
    }

    public function toxyY(): xyY {
        $outcome = Convert::RGB_to_xyY($this->getValues(), $this->primaries);
        return 
            (new xyY($outcome))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLab(): Lab {
        $outcome = Convert::RGB_to_Lab($this->getValues(), $this->primaries);
        return 
            (new Lab($outcome))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh(): LCh {
        $outcome = Convert::RGB_to_LCh($this->getValues(), $this->primaries);
        return 
            (new LCh($outcome))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLuv(): Luv {
        $outcome = Convert::RGB_to_Luv($this->getValues(), $this->primaries);
        return 
            (new Luv($outcome))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toLCh_uv(): LCh_uv {
        $outcome = Convert::RGB_to_LCh_uv($this->getValues(), $this->primaries);
        return 
            (new LCh_uv($outcome))
                ->setIlluminant($this->illuminant, $this->illuminantAngle === null ? 2 : $this->illuminantAngle)
                ->setIlluminantName($this->illuminantName)
                ->setIlluminantTristimulus($this->illuminantT);
    }

    public function toRGB($primaries = null): RGB {
        return $this;
    }
}