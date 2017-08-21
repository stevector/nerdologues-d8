<?php

namespace Drupal\cdn\Asset;

use Drupal\Core\Asset\AssetOptimizerInterface;

/**
 * Decorates CSS asset optimizer: ensures file URLs are rewritten to the CDN.
 *
 * @see cdn_file_url_alter()
 * @see https://www.drupal.org/node/2745109
 */
class CssOptimizer implements AssetOptimizerInterface {

  /**
   * The decorated CSS asset optimizer service.
   *
   * @var \Drupal\Core\Asset\AssetOptimizerInterface
   */
  protected $decoratedCssOptimizer;

  /**
   * @param \Drupal\Core\Asset\AssetOptimizerInterface $decorated_css_optimizer
   *   The decorated CSS asset optimizer service.
   */
  public function __construct(AssetOptimizerInterface $decorated_css_optimizer) {
    $this->decoratedCssOptimizer = $decorated_css_optimizer;
  }

  /**
   * {@inheritdoc}
   */
  public function optimize(array $css_asset) {
    return $this->runWithoutCdnFileAlteration(function () use ($css_asset) {
      return $this->decoratedCssOptimizer->optimize($css_asset);
    });
  }

  /**
   * {@inheritdoc}
   */
  public function clean($contents) {
    return $this->runWithoutCdnFileAlteration(function () use ($contents) {
      return $this->decoratedCssOptimizer->clean($contents);
    });
  }

  /**
   * Wraps callable in an environment where the global $cdn_in_css_file===FALSE.
   *
   * @param callable $callable
   *   A callable.
   *
   * @return mixed
   *   The result of the callable.
   */
  protected function runWithoutCdnFileAlteration(callable $callable) {
    global $cdn_in_css_file;
    $cdn_in_css_file = TRUE;
    $result = $callable();
    $cdn_in_css_file = FALSE;
    return $result;
  }

}
