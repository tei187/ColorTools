<?php

// Utilities
    require_once __DIR__ . "/src/Helpers/CheckArray.php";

// Traits
    require_once __DIR__ . "/src/Traits/Chromaticity.php";
    require_once __DIR__ . "/src/Traits/Tristimulus.php";
    require_once __DIR__ . "/src/Traits/Illuminants.php";
    require_once __DIR__ . "/src/Traits/ReturnsObjects.php";

// Interfaces
    require_once __DIR__ . "/src/Interfaces/Measure.php";

// deltaE
    require_once __DIR__ . "/src/Delta/CIE76.php";
    require_once __DIR__ . "/src/Delta/CIE94.php";
    require_once __DIR__ . "/src/Delta/CIEDE2000.php";
    require_once __DIR__ . "/src/Delta/CIE00.php";
    require_once __DIR__ . "/src/Delta/CMC_Ic.php";

// Chromaticity
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/XYZ_Scaling.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/Von_Kries.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/Bradford.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/CMCCAT2000.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/CIECAT02.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/Sharp.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices.php";
    require_once __DIR__ . "/src/Chromaticity/Adaptation/Adaptation.php";
    require_once __DIR__ . "/src/Chromaticity/Temperature.php";

// Standard Illuminants / standard observers
    require_once __DIR__ . "/src/StandardIlluminants/WhitePoint2.php";
    require_once __DIR__ . "/src/StandardIlluminants/WhitePoint10.php";
    require_once __DIR__ . "/src/StandardIlluminants/Tristimulus2.php";
    require_once __DIR__ . "/src/StandardIlluminants/Tristimulus10.php";

// Converters
    require_once __DIR__ . "/src/Convert.php";

// Objects
    require_once __DIR__ . "/src/Measures/MeasureAbstract.php";
    require_once __DIR__ . "/src/Measures/XYZ.php";
    require_once __DIR__ . "/src/Measures/Lab.php";