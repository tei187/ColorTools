<?php

// Utilities
    require_once __DIR__ . "/src/Helpers/ArrayMethods.php";
    require_once __DIR__ . "/src/Helpers/ClassMethods.php";

// Interfaces
    require_once __DIR__ . "/src/Interfaces/IlluminantDictionary.php";
    require_once __DIR__ . "/src/Interfaces/Companding.php";
    require_once __DIR__ . "/src/Interfaces/Measure.php";
    require_once __DIR__ . "/src/Interfaces/RGBPrimaries.php";
    require_once __DIR__ . "/src/Interfaces/Illuminant.php";

    require_once __DIR__ . "/src/Abstracts/IlluminantDictionary.php";
    require_once __DIR__ . "/src/Dictionaries/Illuminants/Standard/Dictionary.php";
    require_once __DIR__ . "/src/Dictionaries/Illuminants/Standard/WhitePoint2.php";
    require_once __DIR__ . "/src/Dictionaries/Illuminants/Standard/WhitePoint10.php";
    require_once __DIR__ . "/src/Dictionaries/Illuminants/Standard/Tristimulus2.php";
    require_once __DIR__ . "/src/Dictionaries/Illuminants/Standard/Tristimulus10.php";

// Traits
    require_once __DIR__ . "/src/Traits/ConvertsBetweenXYandXYZ.php";
    require_once __DIR__ . "/src/Traits/ChromaticAdaptation.php";
    require_once __DIR__ . "/src/Traits/UsesIlluminant.php";    
    require_once __DIR__ . "/src/Traits/PrimariesLoader.php";
    require_once __DIR__ . "/src/Traits/Companding/GammaCompanding.php";
    require_once __DIR__ . "/src/Traits/Companding/LCompanding.php";
    require_once __DIR__ . "/src/Traits/Companding/sRGBCompanding.php";
    require_once __DIR__ . "/src/Traits/CalculatesDeltaE.php";
    require_once __DIR__ . "/src/Traits/CalculatesContrast.php";

// deltaE
    require_once __DIR__ . "/src/Math/DeltaE/CIE76.php";
    require_once __DIR__ . "/src/Math/DeltaE/CIE94.php";
    require_once __DIR__ . "/src/Math/DeltaE/CIEDE2000.php";
    require_once __DIR__ . "/src/Math/DeltaE/CIE00.php";
    require_once __DIR__ . "/src/Math/DeltaE/CMC_lc.php";
    require_once __DIR__ . "/src/Dictionaries/DeltaE/Dictionary.php";

// Chromaticity
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices/XYZ_Scaling.php";
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices/Von_Kries.php";
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices/Bradford.php";
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices/CMCCAT2000.php";
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices/CIECAT02.php";
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices/Sharp.php";
    require_once __DIR__ . "/src/Dictionaries/CAT/Matrices.php";
    require_once __DIR__ . "/src/Math/Chromaticity/Adaptation.php";
    require_once __DIR__ . "/src/Math/Chromaticity/Temperature.php";

// Standard Illuminants / standard observers
    
    
    require_once __DIR__ . "/src/Illuminants/Illuminant.php";

// Converters
    require_once __DIR__ . "/src/Math/ModelConversion.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Dictionary.php";
    //require_once __DIR__ . "/src/Conversion/RGBPrimaries/Custom.php";
    require_once __DIR__ . "/src/Abstracts/RGBPrimaries.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/AdobeRGB1998.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/AppleRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/BestRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/BetaRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/BruceRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/CIERGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/ColorMatchRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/DonRGB4.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/ECIRGBv2.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/EktaSpacePS5.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/NTSCRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/PALSECAMRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/ProPhotoRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/RadianceRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/SMPTECRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/sRGB.php";
    require_once __DIR__ . "/src/Dictionaries/RGBPrimaries/Standard/Primaries/WideGamutRGB.php";


// Objects
    require_once __DIR__ . "/src/Abstracts/DeviceIndependent.php";
    require_once __DIR__ . "/src/Abstracts/DeviceDependent.php";
    require_once __DIR__ . "/src/ColorModels/Lab.php";
    require_once __DIR__ . "/src/ColorModels/LCh.php";
    require_once __DIR__ . "/src/ColorModels/LCh_uv.php";
    require_once __DIR__ . "/src/ColorModels/Luv.php";
    require_once __DIR__ . "/src/ColorModels/xyY.php";
    require_once __DIR__ . "/src/ColorModels/XYZ.php";
    require_once __DIR__ . "/src/ColorModels/RGB.php";
    require_once __DIR__ . "/src/ColorModels/HSL.php";
    require_once __DIR__ . "/src/ColorModels/HSV.php";
