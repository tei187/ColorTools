# **RGB Primaries**

## **Standard list**

Below the list of available standard RGB primaries:

| Full name      | Illuminant | Class name    | Custom identifiers               |
|----------------|------------|---------------|----------------------------------|
| Adobe RGB 1998 |     D65    | AdobeRGB1998  | _adobe, adobe1998_               |
| Apple RGB      |     D65    | AppleRGB      | _apple_                          |
| Best RGB       |     D50    | BestRGB       | _best_                           |
| Beta RGB       |     D50    | BetaRGB       | _beta_                           |
| Bruce RGB      |     D65    | BruceRGB      | _bruce_                          |
| CIE RGB        |      E     | CIERGB        | _cie_                            |
| ColorMatch RGB |     D50    | ColorMatchRGB | _colormatch, color-match_        |
| Don RGB 4      |     D50    | DonRGB4       | _don4, don_                      |
| ECI RGB v2     |     D50    | ECIRGBv2      | _eci, eciv2_                     |
| Ekta Space PS5 |     D50    | EktaSpacePS5  | _ektaspace, ekta-space, ps5_     |
| NTSC RGB       |      C     | NTSCRGB       | _ntsc_                           |
| PAL/SECAM RGB  |     D65    | PALSECAMRGB   | _palsecam, pal-secam, pal/secam_ |
| ProPhoto RGB   |     D50    | ProPhotoRGB   | _prophoto, pro-photo_            |
| Radiance RGB   |      E     | RadianceRGB   | _radiance_                       |
| SMPTE-C RGB    |     D65    | SMPTECRGB     | _smptec, smpte-c_                |
| sRGB           |     D65    | sRGB          | _rgb_                            |
| Wide Gamut RGB |     D50    | WideGamutRGB  | _widegamut, wide-gamut_          |

<br>

## **Custom primaries**
It is also possible to create an object for custom set of primaries, using `tei187\ColorTools\Conversion\RGBPrimaries\Custom` class namespace.

### **Constructor**
Constructor requires 4 arguments, in order:
* array of arrays with xyY transcription for each channel (R, G, B),
* name for the primaries (can be blank),
* illuminant white point - either a standard illuminant name as string or specific XYZ tristimulus array. If string is passed and does not correspond to any illuminant available, replaced with D65,
* gamma float. By default 2.2. Custom primaries can use only linear gamma companding.

```php
    use tei187\ColorTools\Conversion\RGBPrimaries\Custom as CustomPrimaries;

    $newPrimaries = new CustomPrimaries(
        [ 'R' => [ .7347, .2653, .228457 ],
          'G' => [ .215,  .775,  .737352 ],
          'B' => [ .13,   .035,  .034191 ] ],
        'Custom Primaries Set',
        'D55',
        2.1
    );

    var_dump($newPrimaries->getPrimariesName());  // string(20) "Custom Primaries Set"
    var_dump($newPrimaries->getIlluminantName()); // string(3) "D55"
    var_dump($newPrimaries->getGamma());          // float(2.1)
```