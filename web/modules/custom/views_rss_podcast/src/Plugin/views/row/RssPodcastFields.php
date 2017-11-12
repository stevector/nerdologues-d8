<?php

namespace Drupal\views_rss_podcast\Plugin\views\row;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

use Drupal\views\Plugin\views\row\RssFields;

/**
 * Renders an RSS item based on fields.
 *
 * @ViewsRow(
 *   id = "rss_podcast_fields",
 *   title = @Translation("Podcast Fields"),
 *   help = @Translation("Display fields as RSS items for podcasting."),
 *   theme = "views_view_row_rss",
 *   display_types = {"feed"}
 * )
 */
class RssPodcastFields extends RssFields {

  /**
   * Does the row plugin support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesFields = TRUE;



  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $initial_labels = ['' => $this->t('- None -')];
    $view_fields_labels = $this->displayHandler->getFieldLabels();
    $view_fields_labels = array_merge($initial_labels, $view_fields_labels);

    $form['duration_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Duration field'),
      '#description' => $this->t('The number of seconds in the mp3'),
      '#options' => $view_fields_labels,
      '#default_value' => $this->options['title_field'],
      '#required' => TRUE,
    ];
  }



  public function render($row) {
    static $row_index;
    if (!isset($row_index)) {
      $row_index = 0;
    }

    /*

    if (function_exists('rdf_get_namespaces')) {
      // Merge RDF namespaces in the XML namespaces in case they are used
      // further in the RSS content.
      $xml_rdf_namespaces = [];
      foreach (rdf_get_namespaces() as $prefix => $uri) {
        $xml_rdf_namespaces['xmlns:' . $prefix] = $uri;
      }
      $this->view->style_plugin->namespaces += $xml_rdf_namespaces;
    }

    // Create the RSS item object.
    $item = new \stdClass();
    $item->title = $this->getField($row_index, $this->options['title_field']);
    // @todo Views should expect and store a leading /. See:
    //   https://www.drupal.org/node/2423913
    $item->link = Url::fromUserInput('/' . $this->getField($row_index, $this->options['link_field']))->setAbsolute()->toString();

    $field = $this->getField($row_index, $this->options['description_field']);
    $item->description = is_array($field) ? $field : ['#markup' => $field];

    $item->elements = [
      ['key' => 'pubDate', 'value' => $this->getField($row_index, $this->options['date_field'])],
      [
        'key' => 'dc:creator',
        'value' => $this->getField($row_index, $this->options['creator_field']),
        'namespace' => ['xmlns:dc' => 'http://purl.org/dc/elements/1.1/'],
      ],
    ];
    $guid_is_permalink_string = 'false';
    $item_guid = $this->getField($row_index, $this->options['guid_field_options']['guid_field']);
    if ($this->options['guid_field_options']['guid_field_is_permalink']) {
      $guid_is_permalink_string = 'true';
      // @todo Enforce GUIDs as system-generated rather than user input? See
      //   https://www.drupal.org/node/2430589.
      $item_guid = Url::fromUserInput('/' . $item_guid)->setAbsolute()->toString();
    }
    $item->elements[] = [
      'key' => 'guid',
      'value' => $item_guid,
      'attributes' => ['isPermaLink' => $guid_is_permalink_string],
    ];

    $row_index++;

    foreach ($item->elements as $element) {
      if (isset($element['namespace'])) {
        $this->view->style_plugin->namespaces = array_merge($this->view->style_plugin->namespaces, $element['namespace']);
      }
    }

    $build = [
      '#theme' => $this->themeFunctions(),
      '#view' => $this->view,
      '#options' => $this->options,
      '#row' => $item,
      '#field_alias' => isset($this->field_alias) ? $this->field_alias : '',
    ];
*/
//unset($build["#view"]);
//print_r($build);
//    die();
    $build = parent::render($row);


    $build['#row']->elements[] = [
      'key' => 'itunes:duration',
      'value' => $this->getField($row_index, $this->options['duration_field']),
    ];
    return $build;
  }


}
