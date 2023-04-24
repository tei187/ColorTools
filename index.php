<?php

// Utilities
    require_once __DIR__ . "/src/Helpers/ArrayMethods.php";
    require_once __DIR__ . "/src/Helpers/ClassMethods.php";

// Interfaces
    require_once __DIR__ . "/src/Interfaces/Companding.php";
    require_once __DIR__ . "/src/Interfaces/Measure.php";
    require_once __DIR__ . "/src/Interfaces/Primaries.php";

// Traits
    require_once __DIR__ . "/src/Traits/Chromaticity.php";
    require_once __DIR__ . "/src/Traits/ChromaticAdaptation.php";
    require_once __DIR__ . "/src/Traits/Tristimulus.php";
    require_once __DIR__ . "/src/Traits/Illuminants.php";    
    require_once __DIR__ . "/src/Traits/ReturnsObjects.php";
    require_once __DIR__ . "/src/Traits/PrimariesLoader.php";
    require_once __DIR__ . "/src/Traits/Companding/GammaCompanding.php";
    require_once __DIR__ . "/src/Traits/Companding/LCompanding.php";
    require_once __DIR__ . "/src/Traits/Companding/sRGBCompanding.php";
    require_once __DIR__ . "/src/Traits/Delta.php";

// deltaE
    require_once __DIR__ . "/src/Delta/CIE76.php";
    require_once __DIR__ . "/src/Delta/CIE94.php";
    require_once __DIR__ . "/src/Delta/CIEDE2000.php";
    require_once __DIR__ . "/src/Delta/CIE00.php";
    require_once __DIR__ . "/src/Delta/CMC_lc.php";
    require_once __DIR__ . "/src/Delta/Dictionary.php";

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
    require_once __DIR__ . "/src/StandardIlluminants/Dictionary.php";
    require_once __DIR__ . "/src/StandardIlluminants/WhitePoint2.php";
    require_once __DIR__ . "/src/StandardIlluminants/WhitePoint10.php";
    require_once __DIR__ . "/src/StandardIlluminants/Tristimulus2.php";
    require_once __DIR__ . "/src/StandardIlluminants/Tristimulus10.php";

// Converters
    require_once __DIR__ . "/src/Conversion/Convert.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Dictionary.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Custom.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/PrimariesAbstract.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/AdobeRGB1998.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/AppleRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/BestRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/BetaRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/BruceRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/CIERGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/ColorMatchRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/DonRGB4.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/ECIRGBv2.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/EktaSpacePS5.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/NTSCRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/PALSECAMRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/ProPhotoRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/RadianceRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/SMPTECRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/sRGB.php";
    require_once __DIR__ . "/src/Conversion/RGBPrimaries/Standard/WideGamutRGB.php";


// Objects
    require_once __DIR__ . "/src/Measures/MeasureAbstract.php";
    require_once __DIR__ . "/src/Measures/RGBMeasureAbstract.php";
    require_once __DIR__ . "/src/Measures/Lab.php";
    require_once __DIR__ . "/src/Measures/LCh.php";
    require_once __DIR__ . "/src/Measures/LCh_uv.php";
    require_once __DIR__ . "/src/Measures/Luv.php";
    require_once __DIR__ . "/src/Measures/xyY.php";
    require_once __DIR__ . "/src/Measures/XYZ.php";
    require_once __DIR__ . "/src/Measures/RGB.php";
