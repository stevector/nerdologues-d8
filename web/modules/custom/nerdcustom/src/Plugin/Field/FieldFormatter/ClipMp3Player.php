<?php

/**
 * @file
 * A Field formatter to generate the mp3 player for clips.
 *
 * Only nerdologues members should have bio pages.
 */

namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\node\Entity\Node;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin to make an mp3 player out of the start time field.
 *
 * @FieldFormatter(
 *   id = "nerd_clip_mp3_player",
 *   label = @Translation("Clip Mp3 Player"),
 *   field_types = {
 *     "integer"
 *   }
 * )
 */
class ClipMp3Player extends FormatterBase {


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

    $clip_node = $items->getEntity();
    $clip_mp3 = $this->getMp3($clip_node);

    $elements[] = array(
      '#theme' => 'nerdcustom_mp3_player',
      '#media_link' => $clip_mp3,
      '#value' => $provide_download_link,
      '#extravalue' => $audio_attributes,
    );

    return $elements;
  }

  /**
   * Generate the clip mp3 url.
   */
  protected function getMp3(Node $clip_node) {

    $clip_mp3 = '';
    if (!empty($clip_node->field_ref_podcast_episode)) {
      if (!empty($clip_node->field_ref_podcast_episode->referencedEntities()[0]->field_file->referencedEntities())) {
        $episode_mp3 = $clip_node->field_ref_podcast_episode->referencedEntities()[0]->field_file->referencedEntities()[0]->getFileUri();
        $start_seconds = $clip_node->field_int_start_time->value;
        $end_seconds = $clip_node->field_int_end_time->value;
        $clip_creator = \Drupal::getContainer()->get('nerdcustom.clipcreator');

        $clip_mp3 = $clip_creator->clipMp3FileName($episode_mp3, $clip_node->label(), "https://media.nerdologues.com/clips/v1", $start_seconds, $end_seconds);
      }
    }

    return $clip_mp3;
  }

}
