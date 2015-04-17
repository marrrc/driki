<?php

/**
 * @file
 * Contains \Drupal\interval\Plugin\Field\FieldWidget\DrikiFieldDefaultWidget.
 */

namespace Drupal\driki\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\ParamConverter\ParamNotConvertedException;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\MatchingRouteNotFoundException;
use Drupal\Core\Url;
use Drupal\link\LinkItemInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Plugin implementation of the 'driki_field_default' widget.
 *
 * @FieldWidget(
 *   id = "driki_field_default",
 *   label = @Translation("WikiEntry Field default"),
 *   field_types = {
 *     "driki_field"
 *   },
 *   settings = {
 *     "max_length" = {}
 *   }
 * )
 */
class DrikiFieldDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element += array(
      '#type' => 'fieldset',
      '#title' => 'Driki',
    );

    $element['#attached']['library'][] = 'driki/driki-field-widget-renderer';

    $element['url'] = array(
      '#type' => 'textfield',
      '#title' => t('URL'),
      '#default_value' => isset($items[$delta]->url) ? $items[$delta]->url : NULL,
      // '#default_value' => $items->get($delta)->getUrl(),
      // '#default_value' => 'yolo',
    );

    $formats = filter_formats();
    $format_options = array();
    foreach ($formats as $format) {
      $format_options[$format->id()] = $format->label();
    }

    $element['format'] = array(
      '#type' => 'select',
      '#title' => t('Text format'),
      '#options' => $format_options,
      '#default_value' => isset($items[$delta]->format) ? $items[$delta]->format : NULL,
    );

    $element['wikipage'] = array(
      '#type' => 'hidden',
      '#default_value' => isset($items[$delta]->wikipage) ? $items[$delta]->wikipage : NULL,
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
    public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['max_length'] = array(
      '#type' => 'number',
      '#title' => t('Maximum length'),
      '#default_value' => $this->getSetting('max_length'),
      '#required' => TRUE,
      '#description' => t('The maximum length of the field in characters.'),
      '#min' => 1,
      // '#disabled' => $has_data,
    );

    return $form;
  }

}