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
  }

  /**
   * Take a body field string and return all the potential clip titles in lis.
   *
   * @param string $body_field
   *   A node's body field.
   *
   * @return array
   *   An array of clip titles.
   */
  public function extractClipTitles($body_field) {
    $return = [];
    // Clean problem tags and characters from a string that only needs to be
    // the lists.
    $cleaned_body = strip_tags($body_field, '<ul><li>');
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
