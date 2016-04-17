<?php

/**
 * @file
 * Contains \Drupal\nerdcustom\ClipGenerator.
 */

namespace Drupal\nerdcustom;

use Drupal\Core\Entity\EntityManager;
use Drupal\node\NodeInterface;

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
  public function __construct(EntityManager $entity_manager) {
    $this->entity_manager = $entity_manager;
  }

  
  public function generateClips(NodeInterface $podcast_episode_node) {
  }
  
  
  protected function getBodyField(NodeInterface $podcast_episode_node) {
    // @todo, don't hard code this.
    return '';
  }
  
}
