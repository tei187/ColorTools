# **Chromatic adaptation**

Chromatic adaptation is a process that occurs in the visual system of humans and other animals, allowing us to perceive colors accurately under changing lighting conditions.

When lighting conditions change, such as moving from a bright environment to a darker one or vice versa, the colors we perceive can change as well. This is because the sensitivity of our eyes to different colors can vary depending on the intensity of the light. To compensate for these changes, our visual system uses a process called chromatic adaptation. This involves adjusting the sensitivity of the color-sensitive cells in our eyes to compensate for changes in the intensity of the light.

For example, in a dark environment, the sensitivity of our eyes to blue and violet colors is increased, while the sensitivity of our eyes to red and green colors is decreased. This allows us to see more accurately in low light conditions.

Similarly, in a bright environment, the sensitivity of our eyes to blue and violet colors is decreased, while the sensitivity of our eyes to red and green colors is increased. This allows us to see more accurately in bright conditions.

Overall, chromatic adaptation is an important process that helps us see colors accurately under changing lighting conditions, allowing us to navigate and interact with our environment with greater ease.

## Methods

Chromatic adaptation is done on XYZ model base, using `\tei187\ColorTools\Chromaticity\Adaptation\Adaptation::adapt` method. Arguments explained below:
* XYZ - array holding three values describing the measure/swatch XYZ tristimulus.
* WP_s - source white point / standard illuminant XYZ tristimulus as an array or proper name for standard illuminant as a string.
* WP_d - destination white point / standard illuminant XYZ tristimulus as an array or proper name for standard illuminant as a string.
* M_tran - 3x3 array of chromatic adaptation transformation (CAT) matrix. Others CAT are also available through `\tei187\ColorTools\Chromaticity\Adaptation\Matrices` constans within, as well as a custom 3x3 array describing CAT:
    * ::Bradford _(default)_,
    * ::CIECAT02,
    * ::CMCCAT2000,
    * ::HuntPointerEsteves,
    * ::Sharp,
    * ::Von_Kries,
    * ::XYZ_Scaling.

<br>

Example of adapting XYZ values from D50 to D65 using Bradford BTM:
```php

    use tei187\ColorTools\Chromaticity\Adaptation\Adaptation;
    use tei187\ColorTools\Chromaticity\Adaptation\Matrices;

    $xyz = [ .2967, .3178, .2817 ];

    $adapted = Adaptation::adapt($xyz, 'D50', 'D65', Matrices::Bradford);
    var_dump($adapted);

    /*
    Will return:
    array(3) {
        ["X"]=> float(0.29398243709503)
        ["Y"]=> float(0.318484273531)
        ["Z"]=> float(0.3718079889946)
    }
    */
```

**IMPORTANT:** For ease of use, when converting to RGB, chromatic adaptation is being utilized in the method itself between measure's illuminant and designated illuminant of set RGB primaries.