<?php

namespace Drupal\youtube\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'youtube_video' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_video",
 *   label = @Translation("YouTube video"),
 *   field_types = {
 *     "youtube"
 *   }
 * )
 */
class YouTubeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'youtube_size' => '450x315',
      'youtube_width' => '',
      'youtube_height' => '',
      'youtube_autoplay' => '',
      'youtube_loop' => '',
      'youtube_showinfo' => '',
      'youtube_controls' => '',
      'youtube_autohide' => '',
      'youtube_iv_load_policy' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['youtube_size'] = [
      '#type' => 'select',
      '#title' => $this->t('YouTube video size'),
      '#options' => youtube_size_options(),
      '#default_value' => $this->getSetting('youtube_size'),
    ];
    $elements['youtube_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Width'),
      '#size' => 10,
      '#default_value' => $this->getSetting('youtube_width'),
      '#states' => [
        'visible' => [
          ':input[name*="youtube_size"]' => ['value' => 'custom'],
        ],
      ],
    ];
    $elements['youtube_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Height'),
      '#size' => 10,
      '#default_value' => $this->getSetting('youtube_height'),
      '#states' => [
        'visible' => [
          ':input[name*="youtube_size"]' => ['value' => 'custom'],
        ],
      ],
    ];
    $elements['youtube_autoplay'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Play video automatically when loaded (autoplay).'),
      '#default_value' => $this->getSetting('youtube_autoplay'),
    ];
    $elements['youtube_loop'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Loop the playback of the video (loop).'),
      '#default_value' => $this->getSetting('youtube_loop'),
    ];
    $elements['youtube_showinfo'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide video title and uploader info (showinfo).'),
      '#default_value' => $this->getSetting('youtube_showinfo'),
    ];
    $elements['youtube_controls'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Always hide video controls (controls).'),
      '#default_value' => $this->getSetting('youtube_controls'),
    ];
    $elements['youtube_autohide'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide video controls after play begins (autohide).'),
      '#default_value' => $this->getSetting('youtube_autohide'),
    ];
    $elements['youtube_iv_load_policy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide video annotations by default (iv_load_policy).'),
      '#default_value' => $this->getSetting('youtube_iv_load_policy'),
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $cp = '';
    $youtube_size = $this->getSetting('youtube_size');

    $parameters = [
      $this->getSetting('youtube_autoplay'),
      $this->getSetting('youtube_loop'),
      $this->getSetting('youtube_showinfo'),
      $this->getSetting('youtube_controls'),
      $this->getSetting('youtube_autohide'),
      $this->getSetting('youtube_iv_load_policy'),
    ];

    foreach ($parameters as $parameter) {
      if ($parameter) {
        $cp = ', custom parameters';
        break;
      }
    }
    $summary[] = $this->t('YouTube video: @youtube_size@cp', ['@youtube_size' => $youtube_size, '@cp' => $cp]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareView(array $entities_items) {}

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $settings = $this->getSettings();

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#theme' => 'youtube_video',
        '#input' => $item->input,
        '#video_id' => $item->video_id,
        '#entity_title' => $items->getEntity()->label(),
        '#settings' => $settings,
      ];

      if ($settings['youtube_size'] == 'responsive') {
        $element[$delta]['#attached']['library'][] = 'youtube/drupal.youtube.responsive';
      }
    }
    return $element;
  }

}
