<?php

/**
 * @file
 * Contains \Drupal\nerdcustom\ClipGenerator.
 */

namespace Drupal\nerdcustom;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\node\NodeInterface;
use SimpleXMLElement;

/**
 * Class ClipGenerator.
 *
 * @package Drupal\nerdcustom
 */
// @todo, change name to creator, not generator.
class ClipGenerator {

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
   * Returns the body field string from a node.
   *
   * @param NodeInterface $podcast_episode_node
   *   The node being passed in from hook_entity_insert.
   *
   * @return string
   *   The body field string.
   */
  protected function getBodyField(NodeInterface $podcast_episode_node) {
    // @todo, don't hard code this.
    return '';
  }

  /**
   * Create podcast clips based on an episode.
   *
   * @param NodeInterface $podcast_episode_node
   *   The node being passed in from hook_entity_insert.
   */
  public function generateClips(NodeInterface $podcast_episode_node) {

    if (!$this->validateEpisode($podcast_episode_node)) {
      return;
    }
    if (empty($podcast_episode_node->field_body->getValue()[0]['value'])) {
      return;
    }
    $body_text = $podcast_episode_node->field_body->getValue()[0]['value'];
    foreach ($this->extractClipTitles($body_text) as $clip_title) {
      // dsm($clip_title);
    }
  }

  /**
   * Validate that this node should have clips created for it.
   *
   * @param NodeInterface $podcast_episode_node
   *   The node being passed in from hook_entity_insert.
   */
  protected function validateEpisode(NodeInterface $podcast_episode_node) {
    if ($podcast_episode_node->bundle() === 'podcast_episode' && $podcast_episode_node->field_ref_podcast->referencedEntities()[0]->label() === 'Your Stories') {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Take a body field string and return all the potential clip titles in lis.
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
    while (list(, $thing) = each($result)) {
      $return[] = $thing . '';
    }
    return $return;
  }
}
