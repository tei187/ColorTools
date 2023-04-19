# **Standard illuminants**

List of standard illuminants with available chromaticity coordinates of white point for different standard observer:

| Std. Illuminant | 2&deg; Std. Observer | 10&deg; Std. Observer | Description |
|---:|:---:|:---:|---|
| **A** | &#x2714; | &#x2714; | *incandescent / tungsten* |
| **B** | &#x2714; | &#x2714; | *obsolete, direct sunlight at noon* |
| **C** | &#x2714; | &#x2714; | *obsolete, average / North sky daylight / NTSC 1953, PAL-M* |
| **D50** | &#x2714; | &#x2714; | *horizon light, ICC profile PCS* |
| **D55** | &#x2714; | &#x2714; | *mid-morning / mid-afternoon daylight* |
| **D65** | &#x2714; | &#x2714; | *noon daylight: television, sRGB color space* |
| **D75** | &#x2714; | &#x2714; | *North sky daylight* |
| **D93** | &#x2714; | &#x2714; | *high-efficiency blue phosphor monitors, BT.2035* |
| **E** | &#x2714; | &#x2714; | *equal energy* |
| **F1** | &#x2714; | &#x2714; | *daylight fluorescent* |
| **F2** | &#x2714; | &#x2714; | *cool white fluorescent* |
| **F3** | &#x2714; | &#x2714; | *white fluorescent* |
| **F4** | &#x2714; | &#x2714; | *warm white fluorescent* |
| **F5** | &#x2714; | &#x2714; | *daylight fluorescent* |
| **F6** | &#x2714; | &#x2714; | *light white fluorescent* |
| **F7** | &#x2714; | &#x2714; | *D65 simulator, daylight simulator* |
| **F8** | &#x2714; | &#x2714; | *D50 simulator, Sylvania F40 Design 50* |
| **F9** | &#x2714; | &#x2714; | *cool white deluxe fluorescent* |
| **F10** | &#x2714; | &#x2714; | *Philips TL85, Ultralume 50* |
| **F11** | &#x2714; | &#x2714; | *Philips TL84, Ultralume 40* |
| **F12** | &#x2714; | &#x2714; | *Philips TL83, Ultralume 30* |
| **LED_B1** | &#x2714; | &#x2716; | *phosphor-converted blue* |
| **LED_B2** | &#x2714; | &#x2716; | *phosphor-converted blue* |
| **LED_B3** | &#x2714; | &#x2716; | *phosphor-converted blue* |
| **LED_B4** | &#x2714; | &#x2716; | *phosphor-converted blue* |
| **LED_B5** | &#x2714; | &#x2716; | *phosphor-converted blue* |
| **LED_BH1** | &#x2714; | &#x2716; | *mixing of phosphor-converted blue LED and red LED (blue-hybrid)* |
| **LED_RGB** | &#x2714; | &#x2716; | *mixing of red, green, and blue LEDs* |
| **LED_V1** | &#x2714; | &#x2716; | *phosphor-converted violet* |
| **LED_V2** | &#x2714; | &#x2716; | phosphor-converted violet |

All x,y coordinates based on [https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants](https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants)

<br>

## **Classes**

All xy chromatic coordinates and respective XYZ tristimulus values are available (if exist) in
* `tei187\ColorTools\StandardIlluminants\WhitePoint2` *(xy)*,
* `tei187\ColorTools\StandardIlluminants\WhitePoint10` *(xy)*,
* `tei187\ColorTools\StandardIlluminants\Tristimulus2` *(XYZ)*,
* `tei187\ColorTools\StandardIlluminants\Tristimulus10` *(XYZ)*,

as constans arrays, where each constans is a name of specified standard illuminant.

```php
use tei187\ColorTools\StandardIlluminants\WhitePoint2  as WP2;  // Standard illuminant white point, 2 degrees standard observer
use tei187\ColorTools\StandardIlluminants\WhitePoint10 as WP10; // Standard illuminant white point, 10 degrees standard observer
use tei187\ColorTools\StandardIlluminants\Tristimulus2 as T2;   // Standard illuminant tristimulus, 2 degrees standard observer
use tei187\ColorTools\StandardIlluminants\Tristimulus2 as T10;  // Standard illuminant tristimulus, 10 degrees standard observer

print_r(WP2::D50);     // (array) [ 0.34567, 0.3585 ]
print_r(T2::D50);      // (array) [ 0.96421, 1, 0.82519 ]
print_r(T10::LED_B1);  // will throw fatal error, due to undefined LED_B1 tristimulus for 10deg standard observer
```

## **Dictionary**

Alternatively, or for ease of use, one may find the `tei187\ColorTools\StandardIlluminants\Dictionary` class with its methods more approachable. Essentially, methods of this class verify if passed illuminant name exists and retrieve chromatic coordinates or tsistimulus values.

```php
use tei187\ColorTools\StandardIlluminants\Dictionary;

print_r(Dictionary::getChromaticCoordinates('D50', 2)); // (array) [ 0.34567, 0.3585 ]
print_r(Dictionary::getChromaticCoordinates('D65|10')); // (array) [ 0.31382, 0.331  ]
print_r(Dictionary::getTristimulus('D50', 2)); // (array) [ 0.9642119944212,  1, 0.82518828451883 ]
print_r(Dictionary::getTristimulus('D65|10')); // (array) [ 0.94809667673716, 1, 1.0730513595166  ]
```