<?php

namespace Drupal\youtube\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'youtube_default' widget.
 *
 * @FieldWidget(
 *   id = "youtube",
 *   label = @Translation("YouTube video widget"),
 *   field_types = {
 *     "youtube"
 *   },
 * )
 */
class YouTubeDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'placeholder_url' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['placeholder_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for URL'),
      '#default_value' => $this->getSetting('placeholder_url'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $placeholder_url = $this->getSetting('placeholder_url');
    if (empty($placeholder_url)) {
      $summary[] = $this->t('No placeholders');
    }
    else {
      if (!empty($placeholder_url)) {
        $summary[] = $this->t('URL placeholder: @placeholder_url', ['@placeholder_url' => $placeholder_url]);
      }
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['input'] = $element + [
      '#type' => 'textfield',
      '#placeholder' => $this->getSetting('placearrayholder_url'),
      '#default_value' => isset($items[$delta]->input) ? $items[$delta]->input : NULL,
      '#maxlength' => 255,
      '#element_validate' => [[$this, 'validateInput']],
    ];

    if ($element['input']['#description'] == '') {
      $element['input']['#description'] = $this->t('Enter the YouTube URL. Valid
        URL formats include: http://www.youtube.com/watch?v=1SqBdS0XkV4 and
        http://youtu.be/1SqBdS0XkV4.');
    }

    if (isset($items->get($delta)->video_id)) {
      $element['video_id'] = [
        '#prefix' => '<div class="youtube-video-id">',
        '#markup' => $this->t('YouTube video ID: @video_id', ['@video_id' => $items->get($delta)->video_id]),
        '#suffix' => '</div>',
        '#weight' => 1,
      ];
    }
    return $element;
  }

  /**
   * Validate video URL.
   */
  public function validateInput(&$element, FormStateInterface &$form_state, $form) {
    $input = $element['#value'];
    $video_id = youtube_get_video_id($input);

    if ($video_id && strlen($video_id) <= 20) {
      $video_id_element = [
        '#parents' => $element['#parents'],
      ];
      array_pop($video_id_element['#parents']);
      $video_id_element['#parents'][] = 'video_id';
      $form_state->setValueForElement($video_id_element, $video_id);
    }
    elseif (!empty($input)) {
      $form_state->setError($element, $this->t('Please provide a valid YouTube URL.'));
    }
  }

}
