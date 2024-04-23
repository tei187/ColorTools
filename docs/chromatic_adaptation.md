# **Chromatic adaptation**

Chromatic adaptation is a process that occurs in the visual system of humans and other animals, allowing us to perceive colors accurately under changing lighting conditions.

When lighting conditions change, such as moving from a bright environment to a darker one or vice versa, the colors we perceive can change as well. This is because the sensitivity of our eyes to different colors can vary depending on the intensity of the light. To compensate for these changes, our visual system uses a process called chromatic adaptation. This involves adjusting the sensitivity of the color-sensitive cells in our eyes to compensate for changes in the intensity of the light.

For example, in a dark environment, the sensitivity of our eyes to blue and violet colors is increased, while the sensitivity of our eyes to red and green colors is decreased. This allows us to see more accurately in low light conditions.

Similarly, in a bright environment, the sensitivity of our eyes to blue and violet colors is decreased, while the sensitivity of our eyes to red and green colors is increased. This allows us to see more accurately in bright conditions.

Overall, chromatic adaptation is an important process that helps us see colors accurately under changing lighting conditions, allowing us to navigate and interact with our environment with greater ease.

<br>

## **Methods**

### **Static**

Chromatic adaptation is done on XYZ model base, using `\tei187\ColorTools\Math\Chromaticity\Adaptation::adapt` method. Arguments explained below:
* XYZ - array holding three values describing the measure/swatch XYZ tristimulus.
* WP_s - source white point / standard illuminant XYZ tristimulus as an array or proper name for standard illuminant as a string.
* WP_d - destination white point / standard illuminant XYZ tristimulus as an array or proper name for standard illuminant as a string.
* M_tran - 3x3 array of chromatic adaptation transformation (CAT) matrix. Others CAT are also available through `\tei187\ColorTools\Dictionaries\CAT\Matrices` constans within, as well as a custom 3x3 array of floats describing CAT matrix:
    * ::Bradford _(default)_,
    * ::CIECAT02,
    * ::CMCCAT2000,
    * ::HuntPointerEsteves,
    * ::Sharp,
    * ::Von_Kries,
    * ::XYZ_Scaling.

Example of adapting XYZ values from D50 to D65 using Bradford CAT:
```php
use tei187\ColorTools\Chromaticity\Adaptation\Adaptation;
use tei187\ColorTools\Dictionaries\CAT\Matrices;

$xyz = [ .2967, .3178, .2817 ];

$adapted = Adaptation::adapt($xyz, 'D50', 'D65', Matrices::Bradford);
print_r($adapted);
/*
(
    [X] => 0.29398189555895
    [Y] => 0.31848432208093
    [Z] => 0.37180875886393
)
*/
```

**IMPORTANT:** For ease of use, when converting to RGB, chromatic adaptation is being utilized in the method itself between measure's illuminant and designated illuminant of set RGB primaries.

### **Object**

It is possible to use an object method `adapt()`, similarily to conversion methods. What it does is that it takes the object, converts it to XYZ space, applies transformation and converts back to your primary object class.
Adapt accepts two parameters:
* destination - the final white point reference, can be standard illuminant name, xy chromatic coordinates or xyz tristimulus,
* CAT - chromatic adaptation transform matrix (Bradford CAT by default).
```php
use tei187\ColorTools\ColorModels\XYZ;
use tei187\ColorTools\Math\Chromaticity\Adaptation;
use tei187\ColorTools\Dictionaries\CAT\Matrices;

$obj = new XYZ();
$obj->setValues([ .2967, .3178, .2817 ])
    ->setIlluminant('D50', 2);

print_r( $obj->adapt('D65', Matrices::Bradford)->getValues() );
/*
(
    [X] => 0.29398189555895
    [Y] => 0.31848432208093
    [Z] => 0.37180875886393
)
*/
```