# Image Background Modifier

## Overview
This module implements a Modifier which allows you to set background image. It
is possible to set text and link color to black or white. Text shadow and
background will be calculated for best contrast and set to black or white.
Padding will be set for text over the image.

Optionally you can set media queries.

## Installation
1. The module can be installed via the
[standard Drupal installation process](http://drupal.org/node/1897420).
2. It will create a new Paragraph bundle.
3. Add this Paragraph bundle to a field_modifiers field on an entity (Block or
Paragraph) or onto a field on a Look.

### Optional steps for better user experience
1. Use a paragraph Preview view mode on Form display.
2. Use Entity browser module for easier creation and selection of media assets.
3. Enable field_group and organize the minimum height fields (height, units,
vertical align) under a fieldset or tab.

## Maintainers
This module is not maintained; it is based upon a module by developers at
[Morpht](http://morpht.com) as part of the modifiers_pack module.
