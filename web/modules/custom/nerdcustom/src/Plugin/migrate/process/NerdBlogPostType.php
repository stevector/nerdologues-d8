<?php

namespace Drupal\nerdcustom\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin maps "blogpost" to "blog_post".
 *
 * @MigrateProcessPlugin(
 *   id = "nerd_blog_post_type"
 * )
 */
class NerdBlogPostType extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    return 'blog_post';
  }

}
