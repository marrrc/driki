<?php

/**
 * @file
 * Contains \Drupal\driki\Plugin\Field\FieldType\DrikiFieldType.
 */

namespace Drupal\driki\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\MapDataDefinition;

/**
 * Plugin implementation of the 'driki' field type.
 *
 * @FieldType(
 *   id = "driki_field",
 *   label = @Translation("WikiEntry field"),
 *   description = @Translation("Embeds content of a wiki page"),
 *   default_widget = "driki_field_default",
 *   default_formatter = "driki_field_default"
 * )
 */

class DrikiFieldType extends FieldItemBase {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return array('max_length' => 255,) + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field) {
      return array(
        'columns' => array(
          'url' => array(
            'type' => 'varchar',
            'length' => 2048,
            'not null' => TRUE,
            'default' => '',
            'description' => 'Wiki entry URL',
          ),
          'wikipage' => array(
            'type' => 'text',
            'size' => 'big',
            'description' => 'Wiki entry data',
            'not null' => FALSE,
          ),
          'format' => array(
            'type' => 'varchar',
            'length' => 255,
            'default' => 'full_html',
            'description' => 'Text format filters are used from',
            'not null' => TRUE,
          ),
        ),
      );
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() {
      $value = $this->get('url')->getValue();
      return $value === NULL || $value === '';
    }

    // Validation: See hook_field_validate - https://www.drupal.org/node/2064123
    /**
     * {@inheritdoc}
     */
    public function getConstraints() {
      $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
      $constraints = parent::getConstraints();

      if ($max_length = $this->getSetting('max_length')) {
          $constraints[] = $constraint_manager->create('ComplexData', array(
            'value' => array(
              'Length' => array(
                'max' => $max_length,
                'maxMessage' => t('%name: the text may not be longer than @max characters.',
                 array(
                  '%name' => $this->getFieldDefinition()->getLabel(),
                  '@max' => $max_length
                  )
                 ),
                )
              ),
            )
          );
      }

      return $constraints;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl() {
      return $this->get('url')->getString();
    }

    /**
     * {@inheritdoc}
     */
    public function getWikipage() {
      return $this->get('wikipage')->getString();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat() {
      return $this->get('format')->getString();
    }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function isEmpty() {
    //   $value = $this->get('url')->getValue();
    //   return $value === NULL || $value === '';
    // }

    /**
     * Overrides \Drupal\Core\TypedData\FieldItemBase::setValue().
     *
     * @param array|null $values
     *   An array of property values.
     */
    // public function setValue($values, $notify = TRUE) {
    //   parent::setValue($values);
    //   $this->populateComputedValues();
    // }

    /**
     * {@inheritdoc}
     */
    // static $propertyDefinitions;

    /**
     * {@inheritDoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
      $properties['url'] = DataDefinition::create('string')
        ->setLabel(t('URL'));

      $properties['wikipage'] = DataDefinition::create('string')
        ->setLabel(t('Text'));

      $properties['format'] = DataDefinition::create('string')
        ->setLabel(t('Format'));

      return $properties;
    }

    /**
     * Populates computed variables.
     */
    // protected function populateComputedValues() {

        // \Drupal::service('geophp.geophp');

        // $geom = geoPHP::load($this->value);

        // if (!empty($geom)) {
        //   $centroid = $geom->getCentroid();
        //   $bounding = $geom->getBBox();

        //   $this->geo_type = $geom->geometryType();
        //   $this->lon = $centroid->getX();
        //   $this->lat = $centroid->getY();
        //   $this->left = $bounding['minx'];
        //   $this->top = $bounding['maxy'];
        //   $this->right = $bounding['maxx'];
        //   $this->bottom = $bounding['miny'];
        //   $this->geohash = $geom->out('geohash');
        // }

    // }

    /**
     * {@inheritdoc}
     */

    // public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    //   $element = array();

    //   $element['max_length'] = array(
    //     '#type' => 'number',
    //     '#title' => t('Maximum length'),
    //     '#default_value' => $this->getSetting('max_length'),
    //     '#required' => TRUE,
    //     '#description' => t('The maximum length of the field in characters.'),
    //     '#min' => 1,
    //     '#disabled' => $has_data,
    //   );
    //   $element += parent::storageSettingsForm($form, $form_state, $has_data);

    //   return $element;
    // }


}
