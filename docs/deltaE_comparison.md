# **deltaE comparison**

In colorimetry, delta E (ΔE) is a measure of the difference between two colors. 

Delta E is a commonly used unit of measurement in colorimetry, and is often used in a variety of applications, such as color matching, color correction, and color quality control. It is important to note that delta E is a relative measure, and that the exact value of delta E will depend on the specific method of measurement and the units used to express the tristimulus values.
In addition to its use in color matching and color quality control, delta E is also used in a variety of other fields, such as printing, painting, and design. In printing, for example, delta E is often used to compare the colors of different print jobs, and to ensure that they match the original design. In painting, delta E is used to compare the colors of different paints, and to ensure that they match the desired color. In design, delta E is used to compare the colors of different design elements, and to ensure that they match the overall design scheme.

Delta E is also used in a variety of applications in the field of vision science. For example, it is used to measure the color accuracy of displays, such as computer monitors and televisions, and to ensure that they produce colors that are accurate and consistent. It is also used to measure the color vision of individuals, and to diagnose color vision deficiencies, such as color blindness.

<br>

## **Objects**

You can use specific object methods to calculate delta E:
* `deltaCIE76()` for [CIE76](https://en.wikipedia.org/wiki/Color_difference#CIE76) algorithm,
* `deltaCIE94()` for [CIE94](https://en.wikipedia.org/wiki/Color_difference#CIE94) algorithm,
* `deltaCIE00()` for [CIEDE2000](https://en.wikipedia.org/wiki/Color_difference#CIEDE2000) algorithm,
* `deltaCMClc()` for [CMC l:c](https://en.wikipedia.org/wiki/Color_difference#CMC_l:c_(1984)) algorithm.

For CIE94 and CMC l:c refer to class documentation (additional parameters required).

All measure object will use in-built methods to convert values to L\*a\*b, as such the user does not have to pass Lab objects. It is advised however to apply chromatic adaptation to selected one previously to calculating delta E (if source and reference objects use different illuminants).

```php
use tei187\ColorTools\Measures\XYZ;
use tei187\ColorTools\Measures\LCh;

$a = new XYZ([.2967, .3178, .2817]);
$b = new LCh([63.61469287626, 9.1862923416512, 103.13494521567]);

echo $a->deltaCIE00($b);
// 0.39877497284808

echo $a->delta($b, 'cie00');
// 0.39877497284808

```

## **Static methods**

You can use on of the classes of namespace:
* `tei187\ColorTools\Delta\CIE76`,
* `tei187\ColorTools\Delta\CIE94`,
* `tei187\ColorTools\Delta\CIEDE2000`,
* `tei187\ColorTools\Delta\CMC_lc`.

with each of these having a static method called `::calculateDelta(...)`. For CIE94 and CMC l:c refer to class documentation (additional parameters required).

**Important:** all of these methods operate only on and assume arguments to be proper L\*a\*b values.

```php
use tei187\ColorTools\Delta\CIE76;
use tei187\ColorTools\Delta\CIEDE2000;
use tei187\ColorTools\Delta\CMC_lc;

$lab1 = [ 63.16, -3.67, -3.29 ];
$lab2 = [ 63.61, -3.69, -3.48 ];

echo CIE76::calculateDelta([$lab1, $lab2]); 
// 0.48887626246322

echo CIEDE2000::calculateDelta([$lab1, $lab2]);
// 0.41143344077711

echo CMC_lc::calculateDelta([$lab1, $lab2], "acceptability");
// 0.28560354544368
```