<?php

namespace Drupal\modifiers_bg_parallax_text\Plugin\modifiers;

use Drupal\modifiers\Modification;
use Drupal\modifiers\ModifierPluginBase;

/**
 * Provides a Modifier to set the parallax background on an element.
 *
 * @Modifier(
 *   id = "parallax_bg_text_modifier",
 *   label = @Translation("Background Parallax Modifier"),
 *   description = @Translation("Provides a Modifier to set the parallax background and text color on an element"),
 * )
 */
class ParallaxBgTextModifier extends ModifierPluginBase {

  /**
   * {@inheritdoc}
   */
  public static function modification($selector, array $config) {

    if (!empty($config['parallax'])) {

      if (!empty($config['screen_width'])) {
        $config['media_query'] = $config['screen_width'];
      }
      $media = parent::getMediaQuery($config);

      $css[$media][$selector][] = 'background-image:url("' . $config['parallax'] . '")';

      $libraries = [
        'modifiers_bg_parallax_text/parallax',
        'modifiers_bg_parallax_text/apply',
      ];
      $settings = [
        'namespace' => 'ParallaxBgTextModifier',
        'callback' => 'apply',
        'selector' => $selector,
        'media' => $media,
        'args' => [],
      ];
      if (!empty($config['parallax_speed'])) {
        $settings['args']['speed'] = floatval($config['parallax_speed']);
      }
      if (!empty($config['black_white'])) {
        $css[$media][$selector][] = 'color:' . $config['black_white'];
        $css[$media][$selector . ' a'][] = 'color:' . $config['black_white'];
        // Add padding and increase the font size.
        $css[$media][$selector][] = 'padding:1em; font-size:1.125rem';
        // Adjust the width of the text box.
        if (!empty($config['text_width'])) {
          $css[$media][$selector][] = 'width:100%';
          $css[$media][$selector . ' > :nth-child(1)'][] = 'width:' . $config['text_width'] . '%';
          $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(2) > div'][] = 'width:' . $config['text_width'] . '%';
        }
        // Adjust the alignment of the text box.
        if (!empty($config['horizontal_align'])) {
          if ($config['horizontal_align'] == 'center') {
            $css[$media][$selector . ' > :nth-child(1)'][] = 'margin:0 auto';
            $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(2) > div'][] = 'margin:0 auto';
          }
          if ($config['horizontal_align'] == 'right') {
            $css[$media][$selector . ' > :nth-child(1)'][] = 'float:right';
            $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(2) > div'][] = 'float:right';
          }
        }
        // Set text shadow and background color to the better contrast between black or white.
        if ($config['black_white'] == 'rgba(255,255,255,1)') {
          $css[$media][$selector][] = 'background-color:black; text-shadow:1px 1px 0px black';
          $css[$media][$selector . ' > :nth-child(1)'][] = 'background-color:rgba(0,0,0,0.5); padding:1em';
          // Different selectors for parallax backgrounds within layouts.
          $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(2)'][] = 'padding:0 1em';
          $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(2) > div'][] = 'text-shadow:1px 1px 0px black; background-color:rgba(0,0,0,0.5); padding:1em';
        }
        else {
          $css[$media][$selector][] = 'background-color:white; text-shadow:1px 1px 0px rgba(255,255,255,0.75)';
          $css[$media][$selector . ' > :nth-child(1)'][] = 'background-color:rgba(255,255,255,0.75); padding:1em';
          // Different selectors for parallax backgrounds within layouts.
          $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(2) > div'][] = 'text-shadow:1px 1px 0px white; background-color:rgba(255,255,255,0.75); padding:1em';
        }
        // Adjust background styles for parallax containers that have layouts within.
        $css[$media][$selector . '.modifiers-bundle-layout'][] = 'background-color:transparent; text-shadow:none';
        $css[$media][$selector . '.modifiers-bundle-layout > :nth-child(1)'][] = 'background-color:transparent; padding:0';
        $css[$media]['.modifiers-bundle-layout > :nth-child(2) .modifiers-bundle-layout > :nth-child(2)'][] = 'padding: 0 !important';
    }

      if (!empty($config['height'])) {
        if (!empty($config['vertical_align'])) {
          $css[$media][$selector][] = 'display:flex';

          switch ($config['vertical_align']) {

            case 'top':
              $css[$media][$selector][] = 'align-items:flex-start';
              break;

            case 'middle':
              $css[$media][$selector][] = 'align-items:center';
              break;

            case 'bottom':
              $css[$media][$selector][] = 'align-items:flex-end';
              break;
          }
        }
        $unit = 'em';
        if (!empty($config['height_units'])) {
          $unit = $config['height_units'];
        }
        if ($unit === '%') {
          $libraries = [
            'modifiers_bg_parallax_text/apply',
          ];
          $settings = [
            'namespace' => 'ParallaxBgTextModifier',
            'callback' => 'apply',
            'selector' => $selector,
            'media' => $media,
            'args' => [
              'height' => $config['height'],
            ],
          ];
        }
        else {
          $css[$media][$selector][] = 'min-height:' . $config['height'] . $unit;
        }
      }

      $attributes[$media][$selector]['class'][] = 'modifiers-has-background';

      return new Modification($css, $libraries, $settings, $attributes);
    }
    return NULL;
  }

}
