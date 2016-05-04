<?php

namespace Drupal\Core\Installer\Exception;

/**
 * Thrown when a site has more than one distribution installation profile.
 *
 * @see \Drupal\Core\DrupalKernel::getDistribution()
 */
class TooManyDistributionsException extends \RuntimeException {
}
