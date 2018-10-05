<?php

namespace Drupal\modifiers_image_effects\Plugin\modifiers;

use Drupal\modifiers\Modification;
use Drupal\modifiers\ModifierPluginBase;

/**
 * Provides a Modifier to set the image effects on an element.
 *
 * @Modifier(
 *   id = "image_effects_modifier",
 *   label = @Translation("Image Effects Modifier"),
 *   description = @Translation("Provides a Modifier to set the image effects on an element"),
 * )
 */
class ImageEffectsModifier extends ModifierPluginBase {

  /**
   * {@inheritdoc}
   */
  public static function modification($selector, array $config) {

    if (!empty($config['screen_width'])) {
      $config['media_query'] = $config['screen_width'];
    }
    $media = parent::getMediaQuery($config);

    $filters = '';
    if (!empty($config['image_fx_blur'])) {
      $filters .= ' blur(' . $config['image_fx_blur'] . 'px)';
    }
    if (!empty($config['image_fx_brightness'])) {
      $filters .= ' brightness(' . $config['image_fx_brightness'] . '%)';
    }
    if (!empty($config['image_fx_contrast'])) {
      $filters .= ' contrast(' . $config['image_fx_contrast'] . '%)';
    }
    if (!empty($config['image_fx_hue_rotate'])) {
      $filters .= ' hue-rotate(' . $config['image_fx_hue_rotate'] . 'deg)';
    }
    if (!empty($config['image_fx_invert'])) {
      $filters .= ' invert(' . $config['image_fx_invert'] . '%)';
    }
    if (!empty($config['image_fx_saturate'])) {
      $filters .= ' saturate(' . $config['image_fx_saturate'] . '%)';
    }
    if (!empty($config['image_fx_sepia'])) {
      $filters .= ' sepia(' . $config['image_fx_sepia'] . '%)';
    }
    if (!empty($config['image_fx_opacity'])) {
      $filters .= ' opacity(' . $config['image_fx_opacity'] . '%)';
    }
    if ($filters !== '') {
      $css[$media][$selector . ' img'][] = 'filter:' . $filters;
    }

    $transforms = '';
    if (!empty($config['image_fx_rotate'])) {
      $transforms .= ' rotate(' . $config['image_fx_rotate'] . 'deg)';
    }
    if (!empty($config['image_fx_scale'])) {
      $transforms .= ' scale(' . $config['image_fx_scale'] . ')';
    }
    if ($transforms !== '') {
      $css[$media][$selector . ' img'][] = 'transform:' . $transforms;
    }

    $hoverFilters = '';
    if (!empty($config['image_fx_h_blur'])) {
      $hoverFilters .= ' blur(' . $config['image_fx_h_blur'] . 'px)';
    }
    if (!empty($config['image_fx_h_brightness'])) {
      $hoverFilters .= ' brightness(' . $config['image_fx_h_brightness'] . '%)';
    }
    if (!empty($config['image_fx_h_contrast'])) {
      $hoverFilters .= ' contrast(' . $config['image_fx_h_contrast'] . '%)';
    }
    if (!empty($config['image_fx_h_hue_rotate'])) {
      $hoverFilters .= ' hue-rotate(' . $config['image_fx_h_hue_rotate'] . 'deg)';
    }
    if (!empty($config['image_fx_h_invert'])) {
      $hoverFilters .= ' invert(' . $config['image_fx_h_invert'] . '%)';
    }
    if (!empty($config['image_fx_h_saturate'])) {
      $hoverFilters .= ' saturate(' . $config['image_fx_h_saturate'] . '%)';
    }
    if (!empty($config['image_fx_h_sepia'])) {
      $hoverFilters .= ' sepia(' . $config['image_fx_h_sepia'] . '%)';
    }
    if (!empty($config['image_fx_h_opacity'])) {
      $hoverFilters .= ' opacity(' . $config['image_fx_h_opacity'] . '%)';
    }
    if ($hoverFilters !== '') {
      $css[$media][$selector . ':hover img'][] = 'filter:' . $hoverFilters;
    }

    $hoverTransforms = '';
    if (!empty($config['image_fx_h_rotate'])) {
      $hoverTransforms .= ' rotate(' . $config['image_fx_h_rotate'] . 'deg)';
    }
    if (!empty($config['image_fx_h_scale'])) {
      $hoverTransforms .= ' scale(' . $config['image_fx_h_scale'] . ')';
    }
    if ($hoverTransforms !== '') {
      $css[$media][$selector . ':hover img'][] = 'transform:' . $hoverTransforms;
    }

    if (!empty($config['transition_duration'])) {
      $css[$media][$selector . ' img'][] = 'transition-duration:' . $config['transition_duration'] . 's';
    }

    if (!empty($css)) {
      return new Modification($css);
    }
    return NULL;
  }

}
