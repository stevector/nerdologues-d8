<?php

namespace Drupal\youtube\Plugin\Field\FieldFormatter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'youtube_thumbnail' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_thumbnail",
 *   label = @Translation("YouTube thumbnail"),
 *   field_types = {
 *     "youtube"
 *   }
 * )
 */
class YouTubeThumbFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'image_style' => 'thumbnail',
      'image_link' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Image style'),
      '#options' => image_style_options(FALSE),
      '#default_value' => $this->getSetting('image_style'),
      '#empty_option' => $this->t('None (original image)'),
    ];
    $link_types = [
      'content' => $this->t('Content'),
      'youtube' => $this->t('YouTube'),
    ];
    $elements['image_link'] = [
      '#title' => $this->t('Link image to'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('image_link'),
      '#empty_option' => $this->t('Nothing'),
      '#options' => $link_types,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $image_style = $this->getSetting('image_style');
    $image_link = $this->getSetting('image_link');

    if ($image_style) {
      $summary[] = $this->t('Image style: @style_name.', ['@style_name' => $image_style]);
    }
    if ($image_link) {
      $summary[] = $this->t('Linked to: @image_link.', ['@image_link' => $image_link]);
    }

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
    $entity = $items->getEntity();
    $image_link = $this->getSetting('image_link');

    // Check if the formatter involves a link.
    if (!empty($image_link)) {
      if ($image_link == 'content' && $entity->hasLinkTemplate('canonical')) {
        $url = $entity->toUrl();
        $url->setOption('html', TRUE);
      }
      elseif ($image_link == 'youtube') {
        $link_youtube = TRUE;
      }
    }

    foreach ($items as $delta => $item) {
      // If the thumbnail is linked to its youtube page, take the original url.
      if (isset($link_youtube) && $link_youtube) {
        $url = Url::fromUri($item->input);
        $url->setOption('html', TRUE);
      }

      $element[$delta] = [
        '#theme' => 'youtube_thumbnail',
        '#video_id' => $item->video_id,
        '#entity_title' => $items->getEntity()->label(),
        '#image_style' => $this->getSetting('image_style'),
        '#image_link' => isset($url) ? $url : '',
      ];
    }

    return $element;
  }

}
