# **Conversion**

## **Applicable models**

Conversion can be done between pairs of different color models and transcriptions. List:
* L\*a\*b,
* LCh,
* LCh UV,
* Luv,
* RGB,
* xyY,
* XYZ.

## **Methodology**

### **Objects**

An object corresponding to color model can be created using one of the classes:
* `tei187\ColorTools\Measures\Lab`,
* `tei187\ColorTools\Measures\LCh`,
* `tei187\ColorTools\Measures\LCh_uv`,
* `tei187\ColorTools\Measures\Luv`,
* `tei187\ColorTools\Measures\RGB`,
* `tei187\ColorTools\Measures\xyY`,
* `tei187\ColorTools\Measures\XYZ`.


#### **Constructor**
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

#### **Assigning**
```php
    use tei187\ColorTools\Measures\Lab;

    $swatch_Lab = new Lab();
    $swatch_Lab->setValues(63.16, -3.67, -3.29) // set values
               ->setIlluminant('D50', 2);       // set illuminant
    
```

#### **Special case of RGB**
Due to the fact that there exist different color models used to describe RGB measures, the constructor for RGB requires different input arguments: values and primaries. Values are not atypical to normal constructor. For ease of use, they can be assigned in different ways:
* as an array, with items ranging from 0 to 1,
* as an array, with items ranging from 0 to 255,
* as a string, representing hexadecimal transcription (in form of `'#rrggbb'` or `'#rgb'`).

Primaries, however, are required to reference a defined/standarized object of tei187\Conversion\RGBPrimaries\Standard namespace, coresponding to standarized RGB models. It is done this way because each RGB model has it's own set of primaries and illuminant used to describe the color space.

```php
    use tei187\ColorTools\Measures\RGB;

    $swatch = new RGB('#ff8800', 'sRGB');
```

**IMPORTANT:** converting to RGB will change the object's illuminant to the one typical for specified primaries. If you wish to translate it using a different illuminant white point, chromatic adaptation has to be applied on the conversion outcome.

```php
    use tei187\ColorTools\Measures\Lab;
    use tei187\ColorTools\Measures\RGB;

    $swatch_Lab = new Lab([63.16, -3.67, -3.29], 'D50', 2);
    $swatch_RGB = $swatch_Lab->toRGB('sRGB');

    echo $swatch_RGB->getIlluminantName(); 
    // will output 'D65', even though Lab values were acquired under 'D50', 
    // because 'sRGB' primaries use 'D65' as standard illuminant.

```


### **Static methods**
Each conversion available through object-based classes can be done using just static methods of `tei187\ColorTools\Conversion\Convert` class.