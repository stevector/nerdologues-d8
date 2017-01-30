<?php



namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\media_entity_audio\Plugin\Field\FieldFormatter\AudioPlayerHTML5;


use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Audio Player (HTML5)' formatter.
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
    $elements = array("#markup" => 'hello');
    $provide_download_link = $this->getSetting('provide_download_link');
    $audio_attributes = $this->getSetting('audio_attributes');
/*
 * ugh, I'm going to need a new theme function because media_audio_file_formatter specifically needs a File Entity.
 *
 *
 *
    // The ProcessedText element already handles cache context & tag bubbling.
    // @see \Drupal\filter\Element\ProcessedText::preRenderText()
    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#type' => 'processed_text',
        '#text' => $item->value,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      );
    }


    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      $item = $file->_referringItem;
      $elements[$delta] = array(
        '#theme' => 'media_audio_file_formatter',
        '#file' => $file,
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
*/

    return $elements;
  }


  protect function getMp3() {
    return "https://media.nerdologues.com/clips/v1/HorrorStories22--Cover-Stories--Paint-it-Black--2643-2855.mp3";
  }
  /**
   * A copy of a function from the mp3 clipper server. Generates a filename only.
   *
   * December2012Part2--Dwight---Eric--We-Are-Young--2797-3058.mp3
   */
  function custom_features_content_type_clip_generate_clip_file_name($local_source_file, $story_title, $start_seconds = 0, $end_seconds = 0) {
    $clip_file_name = '';
    $pathinfo = pathinfo($local_source_file);
    $sanitized_story_title = preg_replace("/[^A-Za-z0-9]/", '-', $story_title);
    if (!empty($pathinfo['filename'])  && !empty($pathinfo['extension']) && !empty ($sanitized_story_title)) {
      $clip_file_name = $pathinfo['filename'] . '--' . $sanitized_story_title;
      // Add on seconds to the file name if there are end_seconds.
      if (!empty($end_seconds)) {
        $seconds_portion = $end_seconds;
        if (!empty($start_seconds)) {
          $seconds_portion = $start_seconds . '-' . $end_seconds;
        }
        $clip_file_name .= '--' . $seconds_portion;
      }
      $clip_file_name .= '.' . $pathinfo['extension'];
    }
    return $clip_file_name;
  }
}
