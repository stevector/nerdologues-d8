<?php

namespace Drupal\remote_stream_wrapper\Routing;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;

/**
 * Defines a route subscriber to register a url for serving image styles.
 */
class RemoteImageStyleRoutes implements ContainerInjectionInterface {

  /**
   * The stream wrapper manager service.
   *
   * @var \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface
   */
  protected $streamWrapperManager;

  /**
   * Constructs a new PathProcessorImageStyles object.
   *
   * @param \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $stream_wrapper_manager
   *   The stream wrapper manager service.
   */
  public function __construct(StreamWrapperManagerInterface $stream_wrapper_manager) {
    $this->streamWrapperManager = $stream_wrapper_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('stream_wrapper_manager')
    );
  }

  /**
   * Returns an array of route objects.
   *
   * @return \Symfony\Component\Routing\Route[]
   *   An array of route objects.
   */
  public function routes() {
    $routes = array();

    // Calling getWrappers() here returns an empty array here. Calling the
    // register method seems to resolve it.
    if (method_exists($this->streamWrapperManager, 'register')) {
      $this->streamWrapperManager->register();
    }

    $public_directory_path = $this->streamWrapperManager->getViaScheme('public')->getDirectoryPath();

    // Find all remote stream wrappers.
    $wrappers = $this->streamWrapperManager->getWrappers();

    foreach ($wrappers as $scheme => $wrapper) {
      if (file_is_wrapper_remote($wrapper['class'])) {
        // Manually specify the scheme so that the route is preferred over the
        // image.style_public route.
        $routes['image.style_' . $scheme] = new Route(
          '/' . $public_directory_path . '/styles/{image_style}/' . $scheme,
          array(
            '_controller' => 'Drupal\remote_stream_wrapper\Controller\RemoteImageStyleDownloadController::deliver',
            'scheme' => $scheme,
          ),
          array(
            '_access' => 'TRUE',
          )
        );
      }
    }

    return $routes;
  }

}
