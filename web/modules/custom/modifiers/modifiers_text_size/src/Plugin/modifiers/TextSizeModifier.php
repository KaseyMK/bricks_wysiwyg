<?php

namespace Drupal\modifiers_text_size\Plugin\modifiers;

use Drupal\modifiers\Modification;
use Drupal\modifiers\ModifierPluginBase;

/**
 * Provides a Modifier to set the font size on an element.
 *
 * @Modifier(
 *   id = "text_size_modifier",
 *   label = @Translation("Text Size Modifier"),
 *   description = @Translation("Provides a Modifier to set the font size on an element"),
 * )
 */
class TextSizeModifier extends ModifierPluginBase {

  /**
   * {@inheritdoc}
   */
  public static function modification($selector, array $config) {


    if (!empty($config['text_size'])) {

      if (!empty($config['screen_width'])) {
        $config['media_query'] = $config['screen_width'];
      }
      $media = parent::getMediaQuery($config);

      $css[$media][$selector][] = 'font-size:' . $config['text_size'] . ' !important';

      return new Modification($css);
    }
    return NULL;
  }

}
