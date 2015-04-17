<?php

/**
 * @file
 * Contains \Drupal\driki\Plugin\Field\FieldFormatter\DrikiFieldDefaultFormatter.
 */

namespace Drupal\driki\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\String;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'driki' formatter.
 *
 * @FieldFormatter(
 *   id = "driki_field_default",
 *   module = "driki",
 *   label = @Translation("WikiEntry Field default"),
 *   field_types = {
 *     "driki_field"
 *   }
 * )
 */
class DrikiFieldDefaultFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      // Render output using snippets_default theme.
      $element = array(
        '#theme' => 'driki_field',
        '#wikipage' => check_markup($item->getWikipage(), $item->getFormat()),
      );
      $element['#attached']['library'][] = 'driki/driki-field-renderer';
      $elements[$delta] = array('#markup' => drupal_render($element));
    }

    return $elements;
  }
}