<?php

namespace tei187\ColorTools\Enums;

enum DeltaE: string {
    case CIE76     = "CIE76";
    case CIE94     = "CIE94";
    case CIEDE2000 = "CIEDE2000";
    case CMC_lc    = "CMC_lc";
}