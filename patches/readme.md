# Patches

[Simple patches plugin for Composer](https://github.com/cweagans/composer-patches)

## Overview

We use an external patch file next to root, at patches/composer.patches.json.
Follow the instructions for the cweagans/composer-patches plugin to add or
manage patches to D8.

Patches that we make and maintain ourselves, with no particular value to the
drupal community, are kept in the patches folder and also uploaded to UUA.org
(allow the patch extension and the text/x-diff mimetype), where we can reference
them from our patches json file (which is important since we don't keep contrib
modules in our repo; we can't just edit them directly).
