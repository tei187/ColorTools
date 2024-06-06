<?php

namespace tei187\ColorTools\Enums;

enum DeltaModes: string {
    /**
     * Applicable only for CIE94.
     * 
     * @link \tei187\ColorTools\Math\DeltaE\CIE94 CIE94 deltaE equation.
     */
    case GRAPHIC_ARTS     = "graphic_arts";
    /**
     * Applicable only for CIE94.
     * 
     * @link \tei187\ColorTools\Math\DeltaE\CIE94 CIE94 deltaE equation.
     */
    case TEXTILES         = "textiles";
    /**
     * Applicable only for CMC_lc.
     * 
     * @link \tei187\ColorTools\Math\DeltaE\CMC_lc CMC:lc deltaE equation.
     */
    case ACCEPTABILITY    = "acceptability";
    /**
     * Applicable only for CMC_lc.
     * 
     * @link \tei187\ColorTools\Math\DeltaE\CMC_lc CMC:lc deltaE equation.
     */
    case IMPERCEPTIBILITY = "imperceptibility";
}