<?php

/**
 * @file
 * Contains \Drupal\driki\Plugin\Filter\Redmine.
 */

namespace Drupal\driki\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Url;

/**
 * Provides a filter for redmine.
 *
 * @Filter(
 *   id = "redmine",
 *   module = "redmine",
 *   title = @Translation("Redmine"),
 *   description = @Translation("Allows content to be submitted using Redmine, a simple plain-text syntax that is filtered into valid HTML."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class Redmine extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    if (!empty($text)) {
      $rm_pattern = array(
        // '/[\s|\n](#)([0-9]+)(!#){1}([A-Za-z\-0-9\n][^\s]+)([\s]*)/',
        '/[\s|\n](#)([0-9]+)([-]){1}([A-Za-z0-9-]+)[^\s]/',
        '/[\s|\n]{1}(#)([0-9]+[^A-Za-z,.:\s-])/',
        '/\[\[(.*?)(\|)(.*?)\]\]/',
        '/\[\[(.*?)(\||\:)(.*?)\]\]/',
        '/\[\[(.*?#.*?)(\||\:)(.*?)\]\]/',
        '/\[\[(.*?)\]\]/',
        );
      $rm_replacement = array(
        // '"$1$2$3$4":issues/$2$1$4',
        '"$1$2$3$4":issues/$2$1note-$4',
        '"$1$2":issues/$2',
        '"$3":$1',
        '"$3":$1',
        '"$1":$1',
        );

      $text = preg_replace($rm_pattern, $rm_replacement, $text);
      // print "<pre>";var_dump($text);print "</pre>";exit;
    }

    return new FilterProcessResult($text);
  }
}
