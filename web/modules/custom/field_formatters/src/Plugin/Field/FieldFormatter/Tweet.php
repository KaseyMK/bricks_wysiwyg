<?php

namespace Drupal\field_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'tweet' formatter.
 *
 * @FieldFormatter(
 *   id = "tweet",
 *   label = @Translation("Tweet"),
 *   field_types = {
 *     "text_long"
 *   }
 * )
 */
class Tweet extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays an embedded Tweet.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      // Render each element as markup with script.
      $element[$delta] = array('#markup' => $item->value, '#attached' => array('library'=> array('field_formatters/twitter')));
    }

    return $element;
  }

}
