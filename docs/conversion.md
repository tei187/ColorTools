# **Conversion**

Color conversions refer to the process of converting an image or video from one color space to another. Color spaces are mathematical representations of the way that colors are perceived by the human eye, and they differ from each other in terms of their color gamut (the range of colors that can be represented) and the way that colors are represented (e.g. using RGB, CMYK, or HSV values).

There are several reasons why color conversions might be necessary. For example, an image or video might be captured using one color space, but it needs to be displayed or edited using a different color space. Alternatively, an image or video might be edited or processed using a software tool that supports a particular color space, but it needs to be saved in a different color space.

There are several different techniques that can be used for color conversions, depending on the specific requirements of the conversion. One common technique is to use a color correction algorithm that adjusts the brightness, contrast, and hue of the image or video to achieve a desired color balance.

Another approach is to use a color space conversion algorithm that maps the colors in the source color space to the colors in the destination color space. This involves adjusting the RGB values or other color parameters to match the color gamut and other characteristics of the destination color space.

Overall, color conversions are an important tool for working with images and videos in a variety of different color spaces, and they are an essential part of many image and video editing and processing workflows.

<br>

## **Applicable models**

Conversion can be done between pairs of different color models and transcriptions. List:
* HSL,
* HSV,
* L\*a\*b,
* LCh,
* LCh UV,
* Luv,
* RGB,
* xyY,
* XYZ.

<br>

## **Objects - intro**

An object corresponding to color model can be created using one of the classes:
* `tei187\ColorTools\Measures\HSL`,
* `tei187\ColorTools\Measures\HSV`,
* `tei187\ColorTools\Measures\Lab`,
* `tei187\ColorTools\Measures\LCh`,
* `tei187\ColorTools\Measures\LCh_uv`,
* `tei187\ColorTools\Measures\Luv`,
* `tei187\ColorTools\Measures\RGB`,
* `tei187\ColorTools\Measures\xyY`,
* `tei187\ColorTools\Measures\XYZ`.

<br>

## **Device-independent models**

A device independent colour space is one where the coordinates used to specify the colour will produce the same colour wherever they are applied. In context of this package, they can be equated to models XYZ, xyY, Lab, LCh(ab), LCh(uv) and L\*a\*b.

### **Constructor**
In most cases the constructor will require 3 arguments: values, illuminant type and observer angle.

* **Values**
Values are typically passed as an array of length corresponding to the color model transcription. For example, XYZ will require 3 items in the array, in order corresponding to transcription model.

* **Illuminant**
Each measure type must be based on environment illuminant white point **xy** values. In most cases, these are standarized (list available here) and expect a string input corresponding with standard illuminant name, however it is possible to pass your own custom coordinates in form of array.

* **Observer angle**
Observer angle corresponds to the used illuminant parameter. By default it is 2 degrees. It is required to set it up properly, due to different **xy** values describing the illuminant white point space.

```php
use tei187\ColorTools\Measures\Lab;

$swatch_Lab = new Lab([63.16, -3.67, -3.29], 'D50', 2);
$swatch_XYZ = $swatch_Lab->toXYZ();

var_dump($swatch_XYZ->getValues());
    
/*
    Outputs: 
    Array (
        [X] => 0.29663765251165
        [Y] => 0.317792313707
        [Z] => 0.28166356809766
    )
*/
```

### **Assigning**
```php
use tei187\ColorTools\Measures\Lab;

$swatch_Lab = new Lab();
$swatch_Lab->setValues(63.16, -3.67, -3.29) // set values
           ->setIlluminant('D50', 2);       // set illuminant
    
```

<br>

## **Device-dependent models - RGB**

A device dependent colour space is one where the resultant colour depends on the equipment and the set-up used to produce it. In context of this package, they can be equated to models RGB, HSL, HSV.

### **Constructor**

Due to the fact that there exist different color models used to describe RGB measures, the constructor for RGB requires different input arguments: values and primaries. 
* **Values** are not atypical to normal constructor. For ease of use, they can be assigned in three different ways:
    * as an **array**, with items ranging from **0** to **1** (float/percentage),
    * as an **array**, with items ranging from **0** to **255** (value),
    * as a **string**, representing hexadecimal transcription (in form of **`'#rrggbb'`** or **`'#rgb'`**).
* **Primaries**, however, are required to reference a defined/standarized object of **`tei187\ColorTools\Conversion\RGBPrimaries\Standard` namespace**, coresponding to standarized RGB models. It is done this way because each RGB model has it's own set of primaries and illuminant used to describe the color space. Apart from standard primaries, you can also use custom-created ones (`tei187\ColorTools\Conversion\RGBPrimaries\Custom`) - see **_rgb_primaries.md_** doc for more information.

```php
use tei187\ColorTools\Measures\RGB;

$swatch = new RGB('#ff8800', 'sRGB');
```

### **Conversion**

Converting to RGB **will change the object's illuminant** to the one typical for specified primaries. If you wish to translate it using a different illuminant white point, chromatic adaptation has to be applied on the conversion outcome. This is quite important while converting to device-independent models.

```php
use tei187\ColorTools\Measures\Lab;
use tei187\ColorTools\Measures\RGB;

$swatch_Lab = new Lab([63.16, -3.67, -3.29], 'D50', 2);
$swatch_RGB = $swatch_Lab->toRGB('sRGB');

echo $swatch_RGB->getIlluminantName(); 
// will output 'D65', even though Lab values were acquired under 'D50', 
// because 'sRGB' primaries use 'D65' as standard illuminant.
```

### **Returning values**

Also, RGB-based objects can return values in various formatting.
```php
use tei187\ColorTools\Measures\RGB;

$swatch = new RGB('#ff8800', 'sRGB');

print_r( $swatch->getValues() );         // (array)  [ 'R' => 1, 'G' => 0.53333333333333, 'B' => 0 ]
print_r( $swatch->getValuesFF() );       // (array)  [ 'R' => 255, 'G' => 136, 'B' => 0 ]
print_r( $swatch->getValuesHex(false) ); // (array)  [ 'R' => ff, 'G' => 88, 'B' => 00 ]
print_r( $swatch->getValuesHex(true) );  // (string) "#ff880"
print_r( $swatch->getValuesString() );   // (string) "rgb(255,136,0)"
```

<br>

## **Device-dependent models - HSL & HSV**

Because HSL and HSV models are a representation of RGB model, while converting to device-independent models, it is required to specify the set of RGB primaries to which the HSL and HSV models refer to. If not, sRGB is used as default.

Furthermore, the same as with RGB, converting to device-independent models may require the application of chromatic adaptation to specific illuminant.

<br>

## **Static methods**
Each conversion available through object-based classes can be done using just static methods of `tei187\ColorTools\Conversion\Convert` class.