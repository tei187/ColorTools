# **deltaE comparison**

In colorimetry, delta E \left (ΔE\right ) is a measure of the difference between two colors. 

Delta E is a commonly used unit of measurement in colorimetry, and is often used in a variety of applications, such as color matching, color correction, and color quality control. It is important to note that delta E is a relative measure, and that the exact value of delta E will depend on the specific method of measurement and the units used to express the tristimulus values.
In addition to its use in color matching and color quality control, delta E is also used in a variety of other fields, such as printing, painting, and design. In printing, for example, delta E is often used to compare the colors of different print jobs, and to ensure that they match the original design. In painting, delta E is used to compare the colors of different paints, and to ensure that they match the desired color. In design, delta E is used to compare the colors of different design elements, and to ensure that they match the overall design scheme.

Delta E is also used in a variety of applications in the field of vision science. For example, it is used to measure the color accuracy of displays, such as computer monitors and televisions, and to ensure that they produce colors that are accurate and consistent. It is also used to measure the color vision of individuals, and to diagnose color vision deficiencies, such as color blindness.

<br>

## **Standard list**

| Name      | Namespace                        | Modes                                  | Custom identifiers \*        |
|-----------|----------------------------------|----------------------------------------|------------------------------|
| CIE76     | `tei187\ColorTools\Delta\CIE76`  | N/A                                    | _76_                         |
| CIE94     | `tei187\ColorTools\Delta\CIE94`  | "graphic_arts",<br>"textiles"          | _94_                         |
| CIEDE2000 | `tei187\ColorTools\Delta\CIE00`  | N/A                                    | _ciede00, cie2000, 2000, 00_ |
| CMC l:c   | `tei187\ColorTools\Delta\CMC_lc` | "acceptability",<br>"imperceptibility" | _cmc, cmclc, cmc-lc_         |
<span style="color:red">\*</span> <span style="color:gray">custom identifiers can be used in non-specific delta methods, like `delta\left (\right )` in measures object, instead of using exact class names.</span>

<br>

## **Objects**

You can use specific object methods to calculate delta E:
* `deltaCIE76\left (\right )` for [CIE76]\left (https://en.wikipedia.org/wiki/Color_difference#CIE76\right ) algorithm,
* `deltaCIE94\left (\right )` for [CIE94]\left (https://en.wikipedia.org/wiki/Color_difference#CIE94\right ) algorithm,
* `deltaCIE00\left (\right )` for [CIEDE2000]\left (https://en.wikipedia.org/wiki/Color_difference#CIEDE2000\right ) algorithm,
* `deltaCMClc\left (\right )` for [CMC l:c]\left (https://en.wikipedia.org/wiki/Color_difference#CMC_l:c_\left (1984\right )\right ) algorithm.

Alternatively, for subjective readability improvement, you can as well use a `delta\left (\right )` method, taking parameters of reference swatch and identifier leading to specific delta E class. If the identifier is not set, it defaults to CIE76.

For CIE94 and CMC l:c refer to class documentation \left (additional parameters required\right ).

All measure object will use in-built methods to convert values to L\*a\*b, as such the user does not have to pass Lab objects. It is advised however to apply chromatic adaptation to selected one previously to calculating delta E \left (if source and reference objects use different illuminants\right ).

```php
use tei187\ColorTools\Measures\XYZ;
use tei187\ColorTools\Measures\LCh;

$a = new XYZ\left ([.2967, .3178, .2817]\right );
$b = new LCh\left ([63.61469287626, 9.1862923416512, 103.13494521567]\right );

// Using specific delta method:
    $outcome1 = $a->deltaCIE00\left ($b\right );
    echo $outcome1;
    // 0.39877497284808

// Using non-specific/alternative delta method:
    $outcome2 = $a->delta\left ($b, 'cie00'\right );
    echo $outcome2;
    // 0.39877497284808

// Verifying methods outcomes:
    var_dump\left ($outcome1 === $outcome2\right );
    // bool\left (true\right )
```

## **Static methods**

You can use on of the classes of namespace:
* `tei187\ColorTools\Delta\CIE76`,
* `tei187\ColorTools\Delta\CIE94`,
* `tei187\ColorTools\Delta\CIEDE2000`,
* `tei187\ColorTools\Delta\CMC_lc`.

with each of these having a static method called `::calculateDelta\left (...\right )`. For CIE94 and CMC l:c refer to class documentation \left (additional parameters required\right ).

**Important:** All of these methods operate only on and assume arguments to be proper L\*a\*b values. No array checks are being done.

```php
use tei187\ColorTools\Delta\CIE76;
use tei187\ColorTools\Delta\CIEDE2000;
use tei187\ColorTools\Delta\CMC_lc;

$lab1 = [ 63.16, -3.67, -3.29 ];
$lab2 = [ 63.61, -3.69, -3.48 ];

echo CIE76::calculateDelta\left ([$lab1, $lab2]\right ); 
// 0.48887626246322

echo CIEDE2000::calculateDelta\left ([$lab1, $lab2]\right );
// 0.41143344077711

echo CMC_lc::calculateDelta\left ([$lab1, $lab2], "acceptability"\right );
// 0.28560354544368
```

## Equations

* ### **CIE76**

  $\Delta E_{76} = \sqrt{\left ( L_{2} - L_{1} \right )^{2} + \left ( a_{2} - a_{1} \right )^{2} + \left ( b_{2} - b_{1} \right )^{2}}$

<br>

* ### **CIE94**

  $\Delta E_{94} = \sqrt{\left (\frac{\Delta L}{K_{L} \times S_{L}}\right )^{2} + \left (\frac{\Delta C}{K_{C} \times S_{C}}\right )^{2} + \left (\frac{\Delta H}{K_{H} \times S_{H}}\right )^{2}}$

  where

  $\newline
  K_{L} = \left\{\begin{matrix}
  1 & \textup{default} \\ 
  2 & \textup{textiles}
  \end{matrix}\right.
  \newline
  K_{C} = 1
  \newline
  K_{H} = 1
  \newline\newline
  K_{1} = \left\{\begin{matrix}
   .045 & \textup{graphic arts} \\ 
   .048 & \textup{textiles}
  \end{matrix}\right.
  \newline
  K_{2} = \left\{\begin{matrix}
   .015 & \textup{graphic arts} \\ 
   .014 & \textup{textiles}
  \end{matrix}\right.
  \newline\newline
  C_{1} = \sqrt{{a_{1}}^{2} + {b_{1}}^{2}}
  \newline
  C_{2} = \sqrt{{a_{2}}^{2} + {b_{2}}^{2}}
  \newline\newline
  \Delta a = a_{1} - a_{2}
  \newline
  \Delta b = b_{1} - b_{2}
  \newline\newline
  S_{L} = 1
  \newline
  S_{C} = 1 + \left (K_{1} \times C_{1}\right )
  \newline
  S_{h} = 1 + \left (K_{2} \times C_{1}\right )$

<br>

* ### **CIEDE2000**

  $\Delta E_{00} = {\left (\frac{\Delta {L}'}{k_{L} \times S_{L}}\right )}^{2} + {\left (\frac{\Delta {C}'}{k_{C} \times S_{C}}\right )}^{2} + {\left (\frac{\Delta {H}'}{k_{H} \times S_{H}}\right )}^{2} + R_{T} \times \left (\frac{\Delta {C}'}{k_{C} \times S_{C}}\right )\left (\frac{\Delta {H}'}{k_{H} \times S_{H}}\right )$

  where

  $\forall \,i \in (1,2)
  \newline
  C^{\ast }_{i,ab} = \sqrt{{a^{\ast}_i}^2 + {b^{\ast}_i}^2}
  \newline
  \bar{C}^{\ast}_{ab} = \frac{C^{\ast }_{1,ab} + C^{\ast }_{2,ab}}{2}
  \newline
  G = .5 \times \left ( 1 - \sqrt{\frac{{C^{\ast }_{ab}}^{7}}{{C^{\ast }_{ab}}^{7} + 25^7}} \right )
  \newline
  {a}'_{i} = (1 + G) \times a^{\ast }_{i}
  \newline
  {C}'_{i} = \sqrt{{{a}'_{i}}^2 + {{b}'_{i}}^2}
  \newline
  {h}'_{i} = \begin{cases}
  0 & \text{ if } b^{\ast}_{i} = {a}'_{i} = 0 \\ 
  \tan^{-1}(b^{\ast}_{i}, {a}'_{i}) & \text{ otherwise }
  \end{cases}
  \newline
  \Delta {L}' = L^{\ast}_2 - L^{\ast}_1
  \newline
  \Delta {C}' = {C}'_2 - {C}'_1
  \newline
  \Delta {h}' = \begin{cases}
  0 & \text{ if } {C}'_{1}{C}'_{2} = 0 \\ 
  {h}'_{2} - {h}'_{1} & \text{ if } {C}'_{1}{C}'_{2}\neq0; \left | {h}'_{2} - {h}'_{1} \right | \leq  180^{\circ} \\ 
  \left ( {h}'_{2} - {h}'_{1} \right ) - 360 & \text{ if } {C}'_{1}{C}'_{2}\neq0; \left ( {h}'_{2} - {h}'_{1} \right ) > 180^{\circ} \\ 
  \left ( {h}'_{2} - {h}'_{1} \right ) + 360 & \text{ if } {C}'_{1}{C}'_{2}\neq0; \left ( {h}'_{2} - {h}'_{1} \right )< -180^{\circ}
  \end{cases}
  \newline
  \Delta {H}' = 2 \times \sqrt{{C}'_{1}{C}'_{2}} \times \sin{\left ( \frac{\Delta {h}'}{2} \right )}
  \newline
  {\bar{L}}' = \frac{\left( L^{\ast }_{1} + L^{\ast }_{2} \right )}{2}
  \newline
  {\bar{C}}' = \frac{\left( {C}'_{1} + {C}'_{2} \right )}{2}
  \newline
  {\bar{h}}' = \begin{cases}
  \frac{{h}'_1 + {h}'_2}{2} & \text{ if } \left | {h}'_1 - {h}'_2 \right | \leq 180^{\circ}; {C}'_1 {C}'_2 \neq 0 \\ 
  \frac{{h}'_1 + {h}'_2}{2} + 360^{\circ} & \text{ if } \left | {h}'_1 - {h}'_2 \right | > 180^{\circ}; \left ({h}'_1 + {h}'_2 \right ) < 360^{\circ}; {C}'_1 {C}'_2 \neq 0 \\ 
  \frac{{h}'_1 + {h}'_2}{2} - 360^{\circ} & \text{ if } \left | {h}'_1 - {h}'_2 \right | > 180^{\circ}; \left ({h}'_1 + {h}'_2 \right ) \geq 360^{\circ}; {C}'_1 {C}'_2 \neq 0 \\ 
  {h}'_1 + {h}'_2 & \text{ if } {C}'_1 {C}'_2 \neq 0
  \end{cases}
  \newline
  T = 1 - .17 \times \cos{\left ({\bar{h}}' - 30^{\circ} \right )} + .24 \times \cos{\left (2{\bar{h}}' \right )} + .32 \times \cos{\left (3{\bar{h}}' + 6^{\circ} \right )} - .20 \times \cos{\left (4{\bar{h}}' - 63^{\circ} \right )}
  \newline
  \Delta \theta = 30 \times \exp \left \{ - {\left [ \frac{{\bar{h}' - 275^{\circ}}}{25} \right ]}^2 \right \}
  \newline
  R_{C} = 2 \times \sqrt{ \frac{ ({\bar{C}}')^7 }{ ({\bar{C}}')^7 + 25^7 } }
  \newline
  S_{C} = 1 + .045 \times {\bar{C}}'
  \newline
  S_{H} = 1 + .015 \times {\bar{C}}' \times T
  \newline
  R_{T} = -1 \times \sin(2\Delta \theta) \times R_{C}$

  <br>

* ### **CMC l:c**

  $\Delta E_{CMC} = \sqrt{ \left ( \frac{\Delta L}{l S_{L}} \right ) ^ 2 + \left ( \frac{\Delta C}{c S_{C}} \right ) ^ 2 + \left ( \frac{\Delta H}{S_{H}} \right ) ^ 2 }$

  where
  
  $l = \begin{cases}
  2 & \text{ acceptability } \\ 
  1 & \text{ perceptibility }
  \end{cases}
  \newline
  c = 1
  \newline
  \Delta C = C_{1} - C_{2}
  \newline
  C_{1} = \sqrt{{a_{1}}^2 + {b_{1}}^2}
  \newline
  C_{2} = \sqrt{{a_{2}}^2 + {b_{2}}^2}
  \newline
  \Delta H = \sqrt{ \Delta a ^ 2 + \Delta b ^ 2 - \Delta C ^ 2}
  \newline
  \Delta L = L_{1} - L_{2}
  \newline
  \Delta a = a_{1} - a_{2}
  \newline
  \Delta b = b_{1} - b_{2}
  \newline
  S_{L} = \begin{cases}
  .511 & \text{ if } L_{1} < 16 \\ 
  \frac{.040975 \times L_{1}}{ 1 + .01765 \times L_{1}} & \text{ if } L_{1} \geq 16
  \end{cases}
  \newline
  S_{C} = \frac{.0638 \times C_{1}}{1 + .0131 \times C_{1}} + .638
  \newline
  S_{H} = S_{C} \times (FT + 1 - F)
  \newline
  T = \begin{cases}
  .56 + \left | .2 \times \cos(H_{1} + 168^{\circ})\right | & \text{ if } 164^{\circ} \leq H_{1} \leq 345^{\circ} \\ 
  .36 + \left | .4 \times \cos(H_{1} + 35^{\circ})\right | & \text{ otherwise }
  \end{cases}
  \newline
  F = \sqrt{ \frac{ C_{1}^4 }{ C_{1}^4 + 1900 } }
  \newline
  H = \arctan \left ( \frac{ b_{1} }{ a_{1} } \right )
  \newline
  H_{1} = \begin{cases}
  \newline
  H | & \text{ if } 164^{\circ} \leq H \geq 0 \\ 
  H + 360^{\circ} | & \text{ otherwise }
  \end{cases}$