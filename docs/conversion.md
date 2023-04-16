# Conversion

## Applicable models

Conversion can be done between pairs of different color models and transcriptions. List:
* L\*a\*b,
* LCh,
* LCh UV,
* Luv,
* RGB,
* xyY,
* XYZ.

## Methodology

### Objects

An object corresponding to color model can be created using one of the classes:
* `tei187\ColorTools\Measures\Lab`,
* `tei187\ColorTools\Measures\LCh`,
* `tei187\ColorTools\Measures\LCh_uv`,
* `tei187\ColorTools\Measures\Luv`,
* `tei187\ColorTools\Measures\RGB`,
* `tei187\ColorTools\Measures\xyY`,
* `tei187\ColorTools\Measures\XYZ`.

In most cases the constructor will require 3 arguments: values, illuminant type and observer angle.

#### Values
Values are typically passed as an array of length corresponding to the color model transcription. For example, XYZ will require 3 items in the array, in order corresponding to transcription model.

#### Illuminant
Each measure type must be based on environment illuminant xy values. In most cases, these are standarized (list available here) and expect a string input corresponding with standard illuminant name, however it is possible to pass your own custom coordinates in form of array.

#### Observer angle
Observer angle corresponds to the used illuminant parameter. By default it is 2 degrees. It is required to set it up properly, due to different xy values describing the illuminant space.

#### Special case of RGB
Due to the fact that there exist different color models used to describe RGB measures, the constructor for RGB requires different input arguments: values and primaries. Values are not atypical to normal constructor. Primaries, however, are required to reference a defined/standarized object of tei187\Conversion\RGBPrimaries\Standard namespace, coresponding to standarized RGB models. It is done this way because each RGB model has it's own set of primaries and illuminant used to describe the color space.

### Static methods
Each conversion available through object-based classes can be done using just static methods of `tei187\ColorTools\Conversion\Convert` class.