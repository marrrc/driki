<?php

/**
 * @file
 * Contains \Drupal\driki\Form\DrikiConfigForm.
 */

namespace Drupal\driki\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;

/**
 * Implements the file hash config form.
 */
class DrikiConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'driki_config_form';
  }

  /**
   * {@inheritdoc}.
   */
  protected function getEditableConfigNames() {
    return ['driki.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['urlparams'] = array(
      '#default_value' => $this->config('driki.settings')->get('urlparams'),
      '#description' => t('Additional URL Parameters. E.g. include=attachments (semicolon separates multiple parameters)'),
      '#title' => t('Import Parameters'),
      '#type' => 'textfield',
      // '#default_value' => 'include=attachments',
    );
    // $form['dedupe'] = array(
    //   '#default_value' => $this->config('driki.settings')->get('dedupe'),
    //   '#description' => t('This does nothing at the moment'),
    //   '#title' => t('Placehholder'),
    //   '#type' => 'checkbox',
    // );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('driki.settings')
      ->set('urlparams', $form_state->getValue('urlparams'))
      // ->set('dedupe', $form_state->getValue('dedupe'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
