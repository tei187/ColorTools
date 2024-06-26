# **RGB Primaries**

Color spaces are a fundamental concept in the field of computer graphics and image processing. They are used to represent and manipulate colors in a standardized way, allowing for consistent and accurate color reproduction across different devices and platforms.
Color spaces also play an important role in wide range of color management applications and solutions. By using standardized color spaces, color management systems can ensure that colors are reproduced consistently, even when displayed on different monitors or printed on different media.

There are several types of color spaces, each with their own specific characteristics and uses. One of the most commonly used color spaces is the RGB color space, which represents colors using three primary colors (red, green, and blue) and various shades and intensities of each.

One important aspect of RGB color spaces is the range of colors that can be represented. Since RGB displays work by combining different wavelengths of light, it is possible to represent a wide range of colors, including those that are not available in other color models.
However, it is important to note that RGB color spaces have some limitations. For example, they are not well-suited for representing colors that are not available in the RGB color gamut. Additionally, RGB color spaces do not account for the way that colors are perceived by the human eye, which can lead to color distortion and other issues. These limitations are founded in so-called **RGB primaries**, being the triangular range on which specific RGB model is based in color space.

Typically, RGB primaries consist of chromaticity coordinates for maximal red, green and blue measures, as well as chromaticity coordinates of referencial white point. Other than that, RGB profiles also should have information about standarized gamma (as well as ways of how gamma compands output, which can be profile-specific).
The chromaticity coordinates of the RGB primaries depend on the specific definition of the primaries. In the standard RGB model, the primaries are defined as the points on the color wheel that correspond to the maximum values of the red, green, and blue curves on a graph of luminance (brightness) versus hue (color).

<br>

## **Standard list**

The following table contains the list of standard RGB primaries available through `\tei187\ColorTools\Dictionaries\RGBPrimaries\Standard\Primaries` namespace or loadable through appropriate dictionary.

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