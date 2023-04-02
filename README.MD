# COLOR TOOLS

## Description
Set of classes used to convert colors and calculate color difference.

## Model conversion:
- xy,
- xyY,
- XYZ,
- CIE: 
  - L\*ab,
  - L\*uv,
  - L\*CH.
- HSV,
- HSL,
- RGB:
  - Adobe.
  - Standard.
- CMY, <span style="color:red">\*</span>
- CMYK. <span style="color:red">\*</span>
---
<span style="color:red">\*</span> <span style="color:gray">estimative - direct conversion requires ICC profile data.</span>

## Chromatic adaptation transformations matrices:
- XYZ Scaling,
- Von Kries,
- Bradford,
- CMCCAT2000,
- CIECAT02,
- Sharp.

## White point dictionary of standard illuminants:
*(2&deg; and 10&deg; standard observer)*
- A,
- B,
- C,
- D50, D55, D65, D75, D93,
- E,
- F1, F2, F3, F4, F5, F6, F7, F8, F9, F10, F11, F12,
- LED_B1, LED_B2, LED_B3, LED_B4, LED_B5, LED_BH1, LED_RGB1, LED_V1, LED_V2. <span style="color:red">\*</span>
---
<span style="color:red">\*</span> <span style="color:gray">all LED-based illuminants have 2&deg; standard observer only.</span>

## DeltaE difference:
Check color distance in various algorithms:
- CIE76,
- CIE94,
- CIE00 (CIEDE2000),
- CMC l:c.