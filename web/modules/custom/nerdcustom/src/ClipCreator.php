<?php

namespace Drupal\nerdcustom;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\node\NodeInterface;
use SimpleXMLElement;

/**
 * Class ClipCreator.
 *
 * @package Drupal\nerdcustom
 */
class ClipCreator {

  /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;

  /**
   * Constructor.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * Create podcast clips based on an episode.
   *
   * @param Drupal\node\NodeInterface $podcast_episode_node
   *   The node being passed in from hook_entity_insert.
   */
  public function createClips(NodeInterface $podcast_episode_node) {

    if (!$this->validateEpisode($podcast_episode_node)) {
      return;
    }
    if (empty($podcast_episode_node->field_body->getValue()[0]['value'])) {
      return;
    }
    $body_text = $podcast_episode_node->field_body->getValue()[0]['value'];
    foreach ($this->extractClipTitles($body_text) as $clip_title) {

      $clip_values = [
        'type' => 'clip',
        // No HTML should be present in node titles.
        'title' => strip_tags($clip_title),
        // @todo, is there a cleaner way to target this id?
        'field_ref_podcast' => $podcast_episode_node->field_ref_podcast->referencedEntities()[0],
        'field_ref_podcast_episode' => $podcast_episode_node->id(),
      ];

      $clip = $this->entityManager->getStorage('node')->create($clip_values);
      $clip->save();
    }
  }

  /**
   * Validate that this node should have clips created for it.
   *
   * @param Drupal\node\NodeInterface $podcast_episode_node
   *   The node being passed in from hook_entity_insert. This node might not
   *   actually be a podcast_episode.
   */
  protected function validateEpisode(NodeInterface $podcast_episode_node) {
    if (php_sapi_name() != "cli" && $podcast_episode_node->bundle() === 'podcast_episode' && !empty($podcast_episode_node->field_ref_podcast->referencedEntities()[0]) && $podcast_episode_node->field_ref_podcast->referencedEntities()[0]->label() === 'Your Stories') {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Take a body field string and return all the potential clip titles in list.
   *
   * @param string $body_text
   *   A node's body field.
   *
   * @return array
   *   An array of clip titles.
   */
  public function extractClipTitles($body_text) {
    $return = [];
    // Clean problem tags and characters from a string that only needs to be
    // the lists.
    $cleaned_body = strip_tags($body_text, '<ul><li>');
    $cleaned_body = str_replace('&nbsp;', ' ', $cleaned_body);
    // Strip tags that aren't ul and li because font tags were causing errors.
    $xml = new SimpleXMLElement('<root>' . $cleaned_body . '</root>');
    $result = $xml->xpath('//li');

    foreach ($result as $item) {
      $return[] = $item[0] . '';
    }

    return $return;
  }

  /**
   * A copy of a function from the mp3 clipper server.
   *
   * December2012Part2--Dwight---Eric--We-Are-Young--2797-3058.mp3
   */
  public function clipMp3FileName($local_source_file, $story_title, $base_url, $start_seconds = 0, $end_seconds = 0) {
    $clip_file_name = '';
    $pathinfo = pathinfo($local_source_file);
    $sanitized_story_title = preg_replace("/[^A-Za-z0-9]/", '-', $story_title);
    if (!empty($pathinfo['filename']) && !empty($pathinfo['extension']) && !empty($sanitized_story_title)) {
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
    return $base_url . '/' . $clip_file_name;
  }

}
