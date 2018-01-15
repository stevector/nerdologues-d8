<?php


namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\media_entity_audio\Plugin\Field\FieldFormatter\AudioPlayerHTML5;
use Drupal\Core\Field\FieldItemListInterface;


/**
 * Plugin implementation of the 'Audio Player (HTML5)' formatter.
 *
 * @FieldFormatter(
 *   id = "podcast_episode_audio_player_html5",
 *   label = @Translation("Podcast Audio Player (HTML5)"),
 *   field_types = {
 *     "file"
 *   }
 * )
 */class PodcastEpisodePlayer extends  AudioPlayerHTML5 {


  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $entity = $items->getEntity();
    if (nerdcustom_allow_mp3_print($entity)) {
      return parent::viewElements($items, $langcode);
    }
    else {
      return [];
    }
  }
}
