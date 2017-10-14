<?php

namespace Drupal\media_entity_audio\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Audio Player (HTML5)' formatter.
 *
 * @FieldFormatter(
 *   id = "audio_player_html5",
 *   label = @Translation("Audio Player (HTML5)"),
 *   field_types = {
 *     "file"
 *   }
 * )
 */
class AudioPlayerHTML5 extends AudioPlayerBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings['provide_download_link'] = TRUE;
    $settings['audio_attributes'] = 'controls';

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['provide_download_link'] = [
      '#title' => $this->t('Provide Download Link'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('provide_download_link'),
    ];

    $form['audio_attributes'] = [
      '#title' => $this->t('Audio Tag Attributes'),
      '#type' => 'textfield',
      '#description' => $this->t('Give a space-separeted list of values like: <em>\'controls preload="auto" loop\'</em>. Note that if you remove the <em>\'controls\'</em> tag, your player will not show up.'),
      '#default_value' => $this->getSetting('audio_attributes'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $provide_download_link = $this->getSetting('provide_download_link');
    $audio_attributes = $this->getSetting('audio_attributes');

    if ($provide_download_link) {
      $summary[] = $this->t('Download link provided.');
    }

    if ($audio_attributes) {
      $summary[] = $this->t('Audio tag attributes: @tags.', [
        '@tags' => $audio_attributes,
      ]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    $provide_download_link = $this->getSetting('provide_download_link');
    $audio_attributes = $this->getSetting('audio_attributes');
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      $item = $file->_referringItem;
      $elements[$delta] = array(
        '#theme' => 'media_audio_file_formatter',
        '#file' => $file,
        '#description' => $item->description,
        '#value' => $provide_download_link,
        '#extravalue' => $audio_attributes,
        '#cache' => array(
          'tags' => $file->getCacheTags(),
        ),
      );
      // Pass field item attributes to the theme function.
      if (isset($item->_attributes)) {
        $elements[$delta] += array('#attributes' => array());
        $elements[$delta]['#attributes'] += $item->_attributes;
        // Unset field item attributes since they have been included in the
        // formatter output and should not be rendered in the field template.
        unset($item->_attributes);
      }
    }
    return $elements;
  }

}
