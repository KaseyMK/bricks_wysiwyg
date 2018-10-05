# Background Color Modifier

## Overview
This module implements a Modifier which allows you to use colors from a
controlled vocabulary of Colors defined by you. It is possible to set
background color accompanied by a :hover variant. Text and link color
will be calculated for best contrast and set to black or white. Padding
will be set for non-white backgrounds.

Optionally you can set media queries and transition duration.

This module is modified from modifiers_pack:modifiers_colors

## Installation
1. Install the color_field module (^2.0).
2. The Background Color Modifier module can be installed via the
[standard Drupal installation process](http://drupal.org/node/1897420).
3. It will create a new Paragraph bundle.
4. It will create a new Taxonomy vocabulary "Color", where it is possible to
set the Colors to be used throughout the project.
5. Add this Paragraph bundle to a field_modifiers field on an entity (Block or
Paragraph) or onto a field on a Look.
6. Add the following functions to a .module file (suggest a custom module
called php_functions which holds functions used in more than one place).

```
/**
 * Calculate the luminosity of a given rgba string and return it.
 */
function luminosity_rgba($rgba) {
  if (stripos($rgba, 'rgba') !== false) {
    $res = sscanf($rgba, "rgba(%d, %d, %d, %f)");
  }
  else {
    $res = sscanf($rgba, "rgb(%d, %d, %d)");
    $res[] = 1;
  }
  $r = $res[0]/255;
  $g = $res[1]/255;
  $b = $res[2]/255;
  if ($r <= 0.03928) {
      $r = $r / 12.92;
  } else {
      $r = pow((($r + 0.055) / 1.055), 2.4);
  }
  if ($g <= 0.03928) {
      $g = $g / 12.92;
  } else {
      $g = pow((($g + 0.055) / 1.055), 2.4);
  }
  if ($b <= 0.03928) {
      $b = $b / 12.92;
  } else {
      $b = pow((($b + 0.055) / 1.055), 2.4);
  }
  $luminosity = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
  return $luminosity;
}

/**
 * Calculate the contrast ratio between black or white and a given rgba string.
 * Return the contrast ratio of the higher contrast (against black or white).
 */
function bw_contrast_ratio_rgba($rgba) {
  $luminosity = luminosity_rgba($rgba);
  $ratioBlack = round((($luminosity + 0.05) / (0.05)), 2);
  $ratioWhite = round(((1.05) / ($luminosity + 0.05)), 2);
  if ($ratioBlack > $ratioWhite) {
    return $ratioBlack;
  }
  else {
    return $ratioWhite;
  }
}

/**
 * Calculate the contrast ratio between black or white and a given rgba string.
 * Return the color name (black or white) of the higher contrast.
 */
function bw_contrast_rgba($rgba) {
  $luminosity = luminosity_rgba($rgba);
  $ratioBlack = round((($luminosity + 0.05) / (0.05)), 2);
  $ratioWhite = round(((1.05) / ($luminosity + 0.05)), 2);
  if ($ratioBlack > $ratioWhite) {
    return 'black';
  }
  else {
    return 'white';
  }
}
```

### Optional steps for better user experience
1. Use a paragraph Preview view mode on Form display.
2. Download Spectrum library ([Spectrum](http://bgrins.github.io/spectrum)) to
your libraries folder and change the widget for Color fields to "Spectrum".

## Maintainers
This module is not maintained; it is based upon a module by developers at
[Morpht](http://morpht.com) as part of the modifiers_pack module.
