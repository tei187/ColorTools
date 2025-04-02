# COLOR TOOLS

## Description
Set of classes used to convert colors and calculate color difference.

---

## Features

* ### Model conversion:
  - xy,
  - xyY,
  - XYZ,
  - L\*ab,
  - L\*uv,
  - L\*CH.
  - L\*CH UV.
  - HSV,
  - HSL,
  - RGB for primaries <span style="color:red">\*</span>:
    - Adobe 1998 RGB,
    - Apple RGB,
    - Best RGB,
    - Beta RGB,
    - Bruce RGB,
    - CIE RGB,
    - ColorMatch RGB,
    - Don RGB 4,
    - ECI RGB v2,
    - Ekta Space PS5,
    - NTSC RGB,
    - PAL/SECAM RGB,
    - ProPhoto RGB,
    - Radiance RGB,
    - Rec.709,
    - SMPTE-C RGB,
    - sRGB,
    - WideGamutRGB.
  ---
  <span style="color:red">\*</span> <span style="color:gray">custom-defined primaries also supported.</span>

* ### Chromatic adaptation transformations matrices:
  - Bradford,
  - CIECAT02,
  - CMCCAT2000,
  - Sharp.
  - Von Kries,
  - XYZ Scaling,

* ### White point dictionary of standard illuminants:
  *(2&deg; and 10&deg; standard observer)*
  - A,
  - B,
  - C,
  - D50, D55, D65, D75, D93,
  - E,
  - F1, F2, F3, F4, F5, F6, F7, F8, F9, F10, F11, F12,
  - LED_B1, LED_B2, LED_B3, LED_B4, LED_B5, LED_BH1, LED_RGB1, LED_V1, LED_V2.

* ### DeltaE difference:
  Check color distance in various algorithms:
  - CIE76,
  - CIE94,
  - CIE00 (CIEDE2000),
  - CMC l:c.

* ### Contrast ratio calculation.

## Sources
* [**Bruce Lindbloom** @ brucelindbloom.com](http://www.brucelindbloom.com/)
* [**Color topics for programmers** @ CodeProject.com](https://www.codeproject.com/Articles/1202772/Color-Topics-for-Programmers#CIE_XYZ)
* [**The CIEDE2000 Color-Difference Formula**: Implementation Notes, Supplementary Test Data, and Mathematical Observations | *Gaurav Sharma, Wencheng Wu, Edul N. Dalal* @ rochester.edu](https://hajim.rochester.edu/ece/sites/gsharma/ciede2000/ciede2000noteCRNA.pdf)
* [**The RGB-XYZ Matrix Calculator** @ russellcottrell.com](https://www.russellcottrell.com/photo/matrixCalculator.htm)
* [**Calculate color temperature (CCT) from CIE 1931 xy coordinates** @ waveformlighting.com](https://www.waveformlighting.com/tech/calculate-color-temperature-cct-from-cie-1931-xy-coordinates)
* [**had to know...** Technology Articles @ had2know.org](https://www.had2know.org/technology.html)
* [**Standard Illuminants** - White points of standard illuminants @ Wikipedia.org](https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants)
* [**LMS color space** @ wikipedia.org](https://en.wikipedia.org/wiki/LMS_color_space)

## Requirements
PHP 8.1
