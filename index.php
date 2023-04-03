<?php

require_once __DIR__ . "/src/Helpers/CheckArray.php";

require_once __DIR__ . "/src/Traits/Chromaticity.php";
require_once __DIR__ . "/src/Traits/Tristimulus.php";

require_once __DIR__ . "/src/Delta/CIE76.php";
require_once __DIR__ . "/src/Delta/CIE94.php";
require_once __DIR__ . "/src/Delta/CIEDE2000.php";
require_once __DIR__ . "/src/Delta/CIE00.php";
require_once __DIR__ . "/src/Delta/CMC_Ic.php";

require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/XYZ_Scaling.php";
require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/Von_Kries.php";
require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/Bradford.php";
require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/CMCCAT2000.php";
require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/CIECAT02.php";
require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices/Sharp.php";

require_once __DIR__ . "/src/Chromaticity/Adaptation/Matrices.php";
require_once __DIR__ . "/src/Chromaticity/Adaptation/Adaptation.php";

require_once __DIR__ . "/src/StandardIlluminants/WhitePoint2.php";
require_once __DIR__ . "/src/StandardIlluminants/WhitePoint10.php";
require_once __DIR__ . "/src/StandardIlluminants/Tristimulus2.php";
require_once __DIR__ . "/src/StandardIlluminants/Tristimulus10.php";

require_once __DIR__ . "/src/Convert.php";
require_once __DIR__ . "/src/Chromaticity/Temperature.php";
