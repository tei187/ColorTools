<?php

namespace tei187\ColorTools\Conversion\RGBPrimaries;

class Dictionary {
    const CLASSES = [
        'AdobeRGB1998',
        'AppleRGB',
        'BestRGB',
        'BetaRGB',
        'BruceRGB',
        'CIERGB',
        'ColorMatchRGB',
        'DonRGB4',
        'ECIRGBv2',
        'EktaSpacePS5',
        'NTSCRGB',
        'PALSECAMRGB',
        'ProPhotoRGB',
        'RadianceRGB',
        'SMPTECRGB',
        'sRGB',
        'WideGamutRGB',
    ];

    CONST ASSIGNMENT = [
        'adobe' =>       'AdobeRGB1998',
        'adobe1998' =>   'AdobeRGB1998',
        'apple' =>       'AppleRGB',
        'best' =>        'BestRGB',
        'beta' =>        'BetaRGB',
        'bruce' =>       'BruceRGB',
        'cie' =>         'CIERGB',
        'colormatch' =>  'ColorMatchRGB',
        'color-match' => 'ColorMatchRGB',
        'don4' =>        'DonRGB4',
        'don' =>         'DonRGB4',
        'eciv2' =>       'ECIRGBv2',
        'eci' =>         'ECIRGBv2',
        'ekta' =>        'EktaSpacePS5',
        'ektaspace' =>   'EktaSpacePS5',
        'ekta-space' =>  'EktaSpacePS5',
        'ps5' =>         'EktaSpacePS5',
        'ntsc' =>        'NTSCRGB',
        'palsecam' =>    'PALSECAMRGB',
        'pal-secam' =>   'PALSECAMRGB',
        'pal/secam' =>   'PALSECAMRGB',
        'prophoto' =>    'ProPhotoRGB',
        'pro-photo' =>   'ProPhotoRGB',
        'radiance' =>    'RadianceRGB',
        'smptec' =>      'SMPTECRGB',
        'smpte-c' =>     'SMPTECRGB',
        'rgb' =>         'sRGB',
        'widegamut' =>   'WideGamutRGB',
        'wide-gamut' =>  'WideGamutRGB',
    ];

    public static function assessPrimariesClass($name) {
        $as = "";
        if(is_string($name) && strlen(trim($name)) > 0) {
            $i = array_search(trim($name), self::CLASSES);
            if($i === false) {
                $temp = array_map('strtolower', self::CLASSES);
                $i = array_search(strtolower(trim($name)), $temp);
                if($i === false) {
                    $i = array_search(strtolower(trim($name)), self::ASSIGNMENT);
                    if($i === false) {
                        return false;
                    } else {
                        $as = self::ASSIGNMENT[$i];
                    }
                } else {
                    $as = self::CLASSES[$i];
                }
            } else {
                $as = trim($name);
            }
        }

        return 
            $as !== ""
                ? $as
                : false;
    }
}