# Bricks &amp; WYSIWYG Paragraphs for Impressive Pages Without Ongoing Development

Bricks, paragraphs, and modifiers allow enormously flexible page layouts that are easy for content providers to build. WYSIWYG paragraphs let authors make dynamic content areas interspersed with media in a structured-data format. The combination gives ultimate flexibility to content providers without ongoing developer maintenance.

This repo will install:

* Drupal 8.6.0
* Modules, patches, and libraries (see composer.json, patches/composer.patches.json, web/libraries, and web/modules/custom)
* A Bootstrap-based theme with layouts, styles, and templates (see web/themes/custom)
* Config/sync files for:
  * Paragraph types
  * Page content type
  * A color taxonomy and a view to browse it
  * Entity browsers
  * Text editor embed button
  * Text formats and editors
  * Block layout
  * Image & responsive image styles
  * Display modes for media & paragraphs

[Download the PowerPoint](https://github.com/KaseyMK/bricks_wysiwyg/blob/master/data/readme/bricks-wysiwyg.pptx?raw=true) for a walkthrough.

Instructions and additional detail are below the screenshots.

## Screenshots

### A home page built with bricks

![alt text](https://raw.githubusercontent.com/KaseyMK/bricks_wysiwyg/master/data/readme/page_home.jpg "A page showing a hero area at the top with a background parallax image; then a row with three columns, each showing an image, title, blurb, and link; then a row with two columns, one with a video and the other with large text")
---
### The bricks edit screen showing nested paragraphs

![alt text](https://raw.githubusercontent.com/KaseyMK/bricks_wysiwyg/master/data/readme/page_home_edit.png "The edit screen for the home page shows the image, video and text paragraph types nested under some layout paragraph types")
---
### A simple page with bricks at the bottom

![alt text](https://raw.githubusercontent.com/KaseyMK/bricks_wysiwyg/master/data/readme/page_bricks.jpg "A page showing some text followed by a row containing three columns; the row has a background image on it and the columns (with a 1:2:1 size ratio) contain an image, a video, and another image")
---
### A page with paragraphs embedded via CKEditor as well as bricks in a sidebar

![alt text](https://raw.githubusercontent.com/KaseyMK/bricks_wysiwyg/master/data/readme/page_wysiwyg.jpg "A page with a content area and a sidebar; the page area has images floated within the text and a video box at the bottom; the sidebar shows a stack of images, text, and video")
---
### The edit screen showing paragraphs within the WYSIWYG editor

![alt text](https://raw.githubusercontent.com/KaseyMK/bricks_wysiwyg/master/data/readme/page_wysiwyg_edit.png "The edit screen for this page shows image paragraph types floating within the WYSIWYG text editor as they do on the page")
---
## Instructions

These instructions assume you have installed Composer and know how to set up a local Drupal environment.

In your sites directory, run

```
git clone https://github.com/KaseyMK/bricks_wysiwyg.git
```

Then `cd bricks_wysiwyg` and run `composer install`

Install the site with PHP 7.1 and the MySQL database dump file at `data/bricks-wysiwyg.sql` or create a new database.

### Sample Database and Files

A sample database with color terms and pages can be loaded from the `web` directory with:

`drush sql-drop -y && drush sql-cli < data/bricks-wysiwyg.sql`

Sample images are in `data/files`; move those to `web/sites/default/files` or upload your own.

### With a Fresh Database

If you don't use the sample database, you may need to disable the following modules and then re-enable them one at a time:

* `modifiers_bg_color`
* `modifiers_bg_image_text`
* `modifiers_bg_parallax_text`
* `modifiers_image_effects`
* `modifiers_text_color`
* `modifiers_text_size`

> Enabling those all at once can cause order-of-operation errors that lead to the dreaded WSOD.

Run `drush cim` to import configuration files from sync.

## Usage

Add some colors to the color vocabulary: `/admin/structure/taxonomy/manage/modifiers_color/overview`
OR replace all entity reference color fields with a field of type "Color" with the same machine name.

The "Basic page" content type includes brick fields with layout options above and below the body field, and a bricks field without layout options for the sidebar. The WYSIWYG body field includes an "Add media" button which allows the insertion of image, video, or aside paragraph types (if you're not using the sample database and files, you may need to upload a new button graphic at `/admin/config/content/embed/button/manage/add_media`).

### Adding Paragraph Types

New paragraph types can be added at `/admin/structure/paragraphs_type`.

To include modifiers, add `field_modifiers` to it and select the appropriate modifiers. Remember to disable its display.

Consider its semantic markup; make a custom twig file if necessary in `web/themes/custom/bricks_wysiwyg/templates/paragraph` (copy from default at `modules/contrib/paragraphs/templates/paragraph.html.twig`)

Enable a new paragraph type in a bricks field by editing that field, e.g. at `/admin/structure/types/manage/page/fields/node.page.field_bricks_before`.

To enable a new paragraph type in the WYSIWYG, you must add it to both the entity embed button and to the entity browser.

Edit the `add_media` entity embed button at `/admin/config/content/embed/button/manage/add_media`.

Edit the `browse_paragraphs` entity browser at `/admin/config/content/entity_browser/browse_paragraphs`. Click "Next" until you get to the "Widgets" screen, and add an "Entity form" for the new paragraph type.

### Adding Modifiers

New modifiers must be enabled in each appropriate `field_modifers` field, which are on each of the content and layout paragraph types.

## Modules

The following contrib or non-standard core modules are enabled for the following reasons:

* `admin_toolbar` `admin_toolbar_tools`: Dropdown admin menus are just so handy.
* `allowed_formats`: To prevent embedded paragraphs within embedded paragraphs ad nauseam, only Restricted HTML is allowed within paragraph fields.
* `bricks`: Provides a layout paragraph type and enables the nesting of paragraphs in a bricks field.
* `bricks_inline`: Uses inline entity forms to provide bricks field widgets.
* `bricks_revisions`: Allows revisions of bricks paragraphs to go with content revisions.
* `color_field`: Provides a field type for color HEX values. Used on color taxonomy; could be used instead of entity reference fields on modifiers.
* `ctools` `ctools_block`: Lets us place individual content fields into different theme regions on `/admin/structure/block`
* `entity_browser` `entity_browser_entity_form`: We can create views to allow a user to select a pre-existing entity (like colors from a vocabulary: `/admin/structure/views/view/color_taxonomy`) and then build entity browsers that let users either select an existing entity or create a new one: `/admin/config/content/entity_browser`
* `entity_embed`: Allows the creation of custom embed buttons for use in CKEditor, e.g. `/admin/config/content/embed` which uses the browse_paragraphs entity browser.
* `field_group`: Lets us make nicer, less-confusing forms.
* `field_formatters`: Includes a formatter for letting users embed Tweets safely.
* `inline_entity_form`: Allows complex field widgets which can be used to create other entities.
* `layout_discovery`: Exposes layout files (in the theme folder) to discovery so they're available as selections on the layout paragraph type.
* `linked_field`: Allows any field to be output as a link using any other link field or token. In this site, an image paragraph with a link field will have that link applied to the image.
* `media_library`: An easy way to browse/upload images from a field on an entity. Not quite as good as it should be for video yet; video_embed_field could be used instead.
* `modifiers`: When field_modifiers is added to any entity, enabled modifiers can be applied to that entity.
* `modifiers_bg_color`: Adds a background color to the entity on which it is applied, and calculates the better contrast (between black or white) for text on that entity.
* `modifiers_bg_image_text`: Adds a background image to the entity on which it is applied, and allows the choice of black or white text (with an opaque background of the opposite color to help legibility).
* `modifiers_bg_parallax_text`: Adds a background parallax image to the entity on which it is applied, and allows the choice of black or white text (with an opaque background of the opposite color to help legibility).
* `modifiers_image_effects`: Adds filters that will be applied to any img elements within the entity.
* `modifiers_text_color`: Changes the text color in the entity on which it is applied, and calculates the better contrast (between black or white) for the background color on that entity.
* `modifiers_text_size`: Changes the relative text size for the entity on which it is applied.
* `paragraphs`: Fancy, flexible field collections.
* `php_functions`: PHP functions that are called from several modifer modules to calculate color luminosity and contrast.
* `responsive_image`: Don't deliver a larger image than necessary for your user's screen size.
* `theme_functions`: A simple function to hide a confusing layout that comes with bricks.

## Theme

The [Bootstrap theme](https://www.drupal.org/project/bootstrap) lets us take advantage of preset classes like `col-xs-4` for our layout files (`web/themes/custom/bricks_wysiwyg/templates/layout`) but custom styles could be created instead.

The Bricks-WYSIWYG subtheme is a place to put templates and CSS that help this demo site look nice and help demonstrate why using Paragraphs is cool (image paragraphs can easily be output with the &lt;figure&gt; and &lt;figcaption&gt; elements, for example), but all of those customizations could be applied to any other theme.

## Libraries

[Jarallax](https://github.com/nk-o/jarallax) is required by the Parallax background image modifier. Read the installation instructions in `web/modules/custom/modifiers/modifiers_bg_parallax_text/README.md` carefully.

[Spectrum](http://bgrins.github.io/spectrum) is a color-selecting widget which is normally compatible with the color_field module. It doesn't currently work with the latest versions of Drupal and color_field, but it's included here because being able to choose from a preset selection of color values OR use a color wheel OR enter a hex value is pretty nice. Read the installation instructions in `web/modules/custom/modifiers/modifiers_bg_color/README.md` carefully.

## Patches

See `patches/composer.patches.json` for more information.

If you don't find the custom patches for the entity_embed module (to add a width filter and use it to apply a view mode), you'll probably want to enable more view modes on the `add_media` entity embed button at `/admin/config/content/embed/button/manage/add_media` instead.

## Notes

This package requires specific versions of Drupal and all modules so this documentation is sure to be accurate. Update at will.

The [Modifiers Pack module](https://www.drupal.org/project/modifiers_pack) includes a number of different modifiers upon which this site's modifiers are based. There shouldn't be any conflict in using modifiers from both collections, but pay attention to UI differences that might be confusing.

The [Bootstrap Paragraphs module](https://www.drupal.org/project/bootstrap_paragraphs) includes paragraph types which let you easily create features like Accordions, Carousels, Modals, Tabs, and Multi-column layouts. You may need different versions of these paragraph types for use in the WYSIWYG or within your bricks fields, or choose to enable them in only one or the other.

Drupal's Media module is not yet quite as robust for videos as it is for images (the videos don't size to fit their containers and there's no way to add providers yet). If you can't wait, [video_embed_field](https://www.drupal.org/project/video_embed_field) works well now.
