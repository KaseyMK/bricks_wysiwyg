<?php

namespace Drupal\modifiers_bg_color\Plugin\modifiers;

use Drupal\modifiers\Modification;
use Drupal\modifiers\ModifierPluginBase;

/**
 * Provides a Modifier to set the colors on an element.
 *
 * @Modifier(
 *   id = "color_bg_modifier",
 *   label = @Translation("Color Background Modifier"),
 *   description = @Translation("Provides a Modifier to set the background color on an element and calculate the font color and padding"),
 * )
 */
class BgColorModifier extends ModifierPluginBase {
  /**
   * {@inheritdoc}
   */
  public static function modification($selector, array $config) {

    $css = [];
    $attributes = [];

    if (!empty($config['screen_width'])) {
      $config['media_query'] = $config['screen_width'];
    }
    $media = parent::getMediaQuery($config);

    if (!empty($config['background_color'])) {
      $css[$media][$selector][] = 'background-color:' . $config['background_color'];
      // Reset anything from previous parallax or background images.
      $css[$media][$selector][] = 'text-shadow:none';
      $css[$media][$selector][] = 'background-image:none';
      $css[$media][$selector . ' > :nth-child(1)'][] = 'background-color:transparent; padding:0';
      $css[$media][$selector . ' div[id^=jarallax-container] div'][] = 'background-image:none';
      //$css[$media][$selector][] = 'height:100%';
      $attributes[$media][$selector]['class'][] = 'modifiers-has-background';
      // Set text and link colors to the better contrast between black or white.
      $css[$media][$selector][] = 'color:' . bw_contrast_rgba($config['background_color']);
      $css[$media][$selector . ' a'][] = 'color:' . bw_contrast_rgba($config['background_color']);
      // Add padding if the background isn't white.
      if (stripos($config['background_color'],'rgba(255,255,255') !== 0) {
        $css[$media][$selector][] = 'padding:1em';
      }
      // If the contrast ratio doesn't meet AAA normal WCAG standards
      // (less than 7:1), increase the font size.
      if (bw_contrast_ratio_rgba($config['background_color']) < 7) {
        $css[$media][$selector][] = 'font-size:1.125rem';
      }
    }

    if (!empty($config['h_background_color'])) {
      $css[$media][$selector . ':hover'][] = 'background-color:' . $config['h_background_color'];
      $attributes[$media][$selector]['class'][] = 'modifiers-has-background';
      // Set text and link colors to the better contrast between black or white.
      $css[$media][$selector . ':hover'][] = 'color:' . bw_contrast_rgba($config['h_background_color']);
      $css[$media][$selector . ' a:hover'][] = 'color:' . bw_contrast_rgba($config['h_background_color']);
      $css[$media][$selector . ':hover a'][] = 'color:' . bw_contrast_rgba($config['h_background_color']);
      // Add padding if the background isn't white.
      if (stripos($config['h_background_color'],'rgba(255,255,255') !== 0) {
        $css[$media][$selector][] = 'padding:1em';
      }
      // If the contrast ratio doesn't meet AAA normal WCAG standards
      // (less than 7:1), increase the font size.
      if (bw_contrast_ratio_rgba($config['h_background_color']) < 7) {
        $css[$media][$selector][] = 'font-size:1.125rem';
      }
    }

    if ((!empty($config['background_color'])) && (!empty($config['h_background_color']))) {
      // Add padding if either background isn't white black.
      if ((stripos($config['background_color'],'rgba(255,255,255') !== 0) || (stripos($config['h_background_color'],'rgba(255,255,255') !== 0)) {
        $css[$media][$selector][] = 'padding:1em';
      }
      // If either contrast ratio doesn't meet AAA normal WCAG standards
      // (less than 7:1), increase the font size.
      if ((bw_contrast_ratio_rgba($config['background_color']) < 7) || (bw_contrast_ratio_rgba($config['h_background_color']) < 7)) {
        $css[$media][$selector][] = 'font-size:1.125rem';
      }
    }

    if (!empty($config['transition_duration'])) {
      $css[$media][$selector][] = 'transition-duration:' . $config['transition_duration'] . 's';
      $css[$media][$selector . ':hover'][] = 'transition-duration:' . $config['transition_duration'] . 's';
      $css[$media][$selector . ' a'][] = 'transition-duration:' . $config['transition_duration'] . 's';
      $css[$media][$selector . ' a:hover'][] = 'transition-duration:' . $config['transition_duration'] . 's';
    }

    if (!empty($css) || !empty($attributes)) {

      return new Modification($css, [], [], $attributes);
    }
    return NULL;
  }

}
