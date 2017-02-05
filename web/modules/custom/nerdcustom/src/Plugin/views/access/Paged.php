<?php

/**
 * @file
 * Access plugin for Views that should not display on paginated pages.
 */

namespace Drupal\nerdcustom\Plugin\views\access;

use Drupal\Core\Session\AccountInterface;
use Drupal\views\Plugin\views\PluginBase;
use Symfony\Component\Routing\Route;
use Drupal\views\Plugin\views\access\AccessPluginBase;

/**
 * Return false if the url shows we are using the pager, (not on the homepage).
 *
 * @ingroup views_access_plugins
 *
 * @ViewsAccess(
 *   id = "nerd_paged",
 *   title = @Translation("No access on pagination"),
 *   help = @Translation("Will not be access when 'page' is a param in the url")
 * )
 */
class Paged extends AccessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function summaryTitle() {
    return $this->t('No access on pagination');
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account) {
    $request = $this->view->getRequest();
    // Using means that if the value of page is '0',
    // then this check will return TRUE.
    // And that is what we want.
    return empty($request->query->get('page'));
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return ['url.query_args'];
  }

  /**
   * {@inheritdoc}
   */
  public function alterRouteDefinition(Route $route) {
  }
}
