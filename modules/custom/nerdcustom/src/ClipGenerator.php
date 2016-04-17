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
  protected $entity_manager;
  /**
   * Constructor.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entity_manager = $entity_manager;
  }
  
  public function generateClips(NodeInterface $podcast_episode_node) {
  }

  protected function getBodyField(NodeInterface $podcast_episode_node) {
    // @todo, don't hard code this.
    return '';
  }

  /**
   * Take a body field string and return all the potential clip titles in lis.
   *
   * @param type $body_field
   *   A node's body field.
   * @return array
   *   An array of clip titles.
   */
  public function extractClipTitles($body_field) {
    //$return = [];
    // Clean problem tags and characters from a string that only needs to be
    // the lists.
    $cleaned_body = strip_tags($body_field, '<ul><li>');
    $cleaned_body = str_replace('&nbsp;', ' ', $cleaned_body);
    // Strip all tags that aren't ul and li because font tags were causing errors.
    $xml = new SimpleXMLElement('<root>' . $cleaned_body . '</root>');
    $result = $xml->xpath('//li');
    while(list( , $thing) = each($result)) {
       $return[] = $thing . '';
    }
    return $return;
  }
}
