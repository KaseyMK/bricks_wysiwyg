# Image Effects Modifier

## Overview
This module implements a Modifier which allows you to set CSS effects for
images. Optionally you can set :hover variants and media queries. Some effect
fields are disabled by default.

## Installation
1. The module can be installed via the
[standard Drupal installation process](http://drupal.org/node/1897420).
2. It will create a new Paragraph bundle.
3. Add this Paragraph bundle to a field_modifiers field on an entity (Block or
Paragraph) or onto a field on a Look.

### Optional steps for better user experience
1. Use a paragraph Preview view mode on Form display.
2. Enable field_group and organize the effect fields under an open tab or
fieldset with general instructions, e.g. "Note":
```
<p><em>Not all effects can be applied to the same image; if you run into problems, try reducing or removing an effect. Be sure your effects do not impact usability; for instance, if you rotate an image, you might need to also reduce its scale so that it doesn't cover up text on the page. Effects will not be applied to background images.</em></p>
```

## Maintainers
This module is not maintained; it is based upon a module by developers at
[Morpht](http://morpht.com) as part of the modifiers_pack module.
