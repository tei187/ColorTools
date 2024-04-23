# **Standard illuminants**

A standard illuminant is a known and consistent light source that is used in color measurement to provide a reference for the color of an object or material being measured. In other words, it is a light source that is used to illuminate an object or material in a standardized manner, so that the color of the object or material can be accurately measured and compared to a known standard.

These standard illuminants are defined by specific spectral power distributions and color temperatures, and they are used as references to standardize color measurements and ensure their reproducibility. By using a standard illuminant, it is possible to measure the color of an object or material with high accuracy and consistency, regardless of the lighting conditions or the specific light source being used.

Standard illuminants are often used in combination with color measuring devices, such as colorimeters or spectrophotometers. These devices measure the color of an object or material by illuminating it with a known light source and measuring the reflected light with a sensor. The resulting data can be used to calculate the object or material's color coordinates, which can be compared to the color coordinates of a standard illuminant to determine the object or material's color.

By using a standard illuminant in combination with a color measuring device, it is possible to accurately and reproducibly measure the color of an object or material, even in complex or variable lighting conditions. This is important in many fields, such as color science, materials science, and quality control, where accurate color measurement is critical for ensuring consistency and reproducibility.

<br>

## **List**

List of standard illuminants with available chromaticity coordinates of white point for different standard observer:

| Std. Illuminant | 2&deg; Std. Observer  | 10&deg; Std. Observer | Description                                                       |
|-----------------|:---------------------:|:---------------------:|-------------------------------------------------------------------|
| **A**           | &#x2714;              | &#x2714;              | *incandescent / tungsten*                                         |
| **B**           | &#x2714;              | &#x2714;              | *obsolete, direct sunlight at noon*                               |
| **C**           | &#x2714;              | &#x2714;              | *obsolete, average / North sky daylight / NTSC 1953, PAL-M*       |
| **D50**         | &#x2714;              | &#x2714;              | *horizon light, ICC profile PCS*                                  |
| **D55**         | &#x2714;              | &#x2714;              | *mid-morning / mid-afternoon daylight*                            |
| **D65**         | &#x2714;              | &#x2714;              | *noon daylight: television, sRGB color space*                     |
| **D75**         | &#x2714;              | &#x2714;              | *North sky daylight*                                              |
| **D93**         | &#x2714;              | &#x2714;              | *high-efficiency blue phosphor monitors, BT.2035*                 |
| **E**           | &#x2714;              | &#x2714;              | *equal energy*                                                    |
| **F1**          | &#x2714;              | &#x2714;              | *daylight fluorescent*                                            |
| **F2**          | &#x2714;              | &#x2714;              | *cool white fluorescent*                                          |
| **F3**          | &#x2714;              | &#x2714;              | *white fluorescent*                                               |
| **F4**          | &#x2714;              | &#x2714;              | *warm white fluorescent*                                          |
| **F5**          | &#x2714;              | &#x2714;              | *daylight fluorescent*                                            |
| **F6**          | &#x2714;              | &#x2714;              | *light white fluorescent*                                         |
| **F7**          | &#x2714;              | &#x2714;              | *D65 simulator, daylight simulator*                               |
| **F8**          | &#x2714;              | &#x2714;              | *D50 simulator, Sylvania F40 Design 50*                           |
| **F9**          | &#x2714;              | &#x2714;              | *cool white deluxe fluorescent*                                   |
| **F10**         | &#x2714;              | &#x2714;              | *Philips TL85, Ultralume 50*                                      |
| **F11**         | &#x2714;              | &#x2714;              | *Philips TL84, Ultralume 40*                                      |
| **F12**         | &#x2714;              | &#x2714;              | *Philips TL83, Ultralume 30*                                      |
| **LED_B1**      | &#x2714;              | &#x2716;              | *phosphor-converted blue*                                         |
| **LED_B2**      | &#x2714;              | &#x2716;              | *phosphor-converted blue*                                         |
| **LED_B3**      | &#x2714;              | &#x2716;              | *phosphor-converted blue*                                         |
| **LED_B4**      | &#x2714;              | &#x2716;              | *phosphor-converted blue*                                         |
| **LED_B5**      | &#x2714;              | &#x2716;              | *phosphor-converted blue*                                         |
| **LED_BH1**     | &#x2714;              | &#x2716;              | *mixing of phosphor-converted blue LED and red LED (blue-hybrid)* |
| **LED_RGB1**    | &#x2714;              | &#x2716;              | *mixing of red, green, and blue LEDs*                             |
| **LED_V1**      | &#x2714;              | &#x2716;              | *phosphor-converted violet*                                       |
| **LED_V2**      | &#x2714;              | &#x2716;              | *phosphor-converted violet*                                       |

All x,y coordinates based on [https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants](https://en.wikipedia.org/wiki/Standard_illuminant#White_points_of_standard_illuminants)

<br>

## **Classes**

All xy chromatic coordinates and respective XYZ tristimulus values are available (if specific measure exists) in
* `tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint2` *(xy)*,
* `tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint10` *(xy)*,
* `tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus2` *(XYZ)*,
* `tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus10` *(XYZ)*,

as constans arrays, where each constans is a name of specified standard illuminant.

```php
use tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint2  as WP2;  // Standard illuminant white point, 2 degrees standard observer
use tei187\ColorTools\Dictionaries\Illuminants\Standard\WhitePoint10 as WP10; // Standard illuminant white point, 10 degrees standard observer
use tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus2 as T2;   // Standard illuminant tristimulus, 2 degrees standard observer
use tei187\ColorTools\Dictionaries\Illuminants\Standard\Tristimulus2 as T10;  // Standard illuminant tristimulus, 10 degrees standard observer

print_r(WP2::D50);     // (array) [ 0.34567, 0.3585 ]
print_r(T2::D50);      // (array) [ 0.96421, 1, 0.82519 ]
print_r(T10::LED_B1);  // will throw fatal error, due to undefined LED_B1 tristimulus for 10deg standard observer
```

<br>

## **Object**

You can also create a new `tei187\ColorTools\Illuminants\Illuminant` object with its respective chromatic coordinates or tristimulus values.
```php
use tei187\ColorTools\Illuminants\Illuminant;

$illuminant_d50_2 = Illuminant::from('D50', 2);

print_r($illuminant_d50_2->get('whitepoint'));
// (array) [ 0.34567, 0.3585 ]
print_r($illuminant_d50_2->get('tristimulus'));
// (array) [ 0.9642119944212,  1, 0.82518828451883 ]

//

$illuminant_d50_10 = Illuminant::from('D50', 10);

print_r($illuminant_d50_10->get('whitepoint'));
// (array) [ 0.34567, 0.3585 ]
print_r($illuminant_d50_10->get('tristimulus'));
// (array) [ 0.94809667673716, 1, 1.0730513595166  ]
```

<br>

## **Dictionary**

Alternatively, or for ease of use, one may find the `tei187\ColorTools\Dictionaries\Illuminants\Standard\Dictionary` class with its methods more approachable. Essentially, methods of this class verify if passed illuminant name exists and retrieve chromatic coordinates or tsistimulus values.

```php
use tei187\ColorTools\Dictionaries\Illuminants\Standard\Dictionary;

print_r(Dictionary::getChromaticCoordinates('D50', 2));
// (array) [ 0.34567, 0.3585 ]

print_r(Dictionary::getChromaticCoordinates('D65|10'));
// (array) [ 0.31382, 0.331  ]

print_r(Dictionary::getTristimulus('D50', 2));
// (array) [ 0.9642119944212,  1, 0.82518828451883 ]

print_r(Dictionary::getTristimulus('D65|10'));
// (array) [ 0.94809667673716, 1, 1.0730513595166  ]
```