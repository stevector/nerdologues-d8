<?php

/**
 * @file
 * Generate absolute urls for images.
 */

namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\Core\Cache\CacheableMetadata;
use  Drupal\image\Plugin\Field\FieldFormatter\ImageUrlFormatter;
use Drupal\Core\Field\FieldItemListInterface;


/**
 * Plugin implementation of the 'image_url' formatter.
 *
 * @FieldFormatter(
 *   id = "image_absolute_url",
 *   label = @Translation("Absolute URL to image"),
 *   field_types = {
 *     "image"
 *   }
 * )
 */
class ImageAbsoluteUrlFormatter extends ImageUrlFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    /** @var \Drupal\Core\Field\EntityReferenceFieldItemListInterface $items */
    if (empty($images = $this->getEntitiesToView($items, $langcode))) {
      // Early opt-out if the field is empty.
      return $elements;
    }

    $image_style = $this->imageStyleStorage->load($this->getSetting('image_style'));
    foreach ($images as $delta => $image) {
      $image_uri = $image->getFileUri();
      $url = $image_style ? $image_style->buildUrl($image_uri) : file_create_url($image_uri);

      // This plugin exists only to comment out this one line
      // so that the url stays absolute.
      // $url = file_url_transform_relative($url);
      // Add cacheability metadata from the image and image style.
      $cacheability = CacheableMetadata::createFromObject($image);
      if ($image_style) {
        $cacheability->addCacheableDependency(CacheableMetadata::createFromObject($image_style));
      }

      $elements[$delta] = ['#markup' => $url];
      $cacheability->applyTo($elements[$delta]);
    }
    return $elements;
  }

}
