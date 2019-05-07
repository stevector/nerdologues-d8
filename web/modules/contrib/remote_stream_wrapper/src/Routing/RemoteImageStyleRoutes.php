<?php

namespace Drupal\remote_stream_wrapper\Routing;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
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
   * The module handler used to check whether the image module exists.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new PathProcessorImageStyles object.
   *
   * @param \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $stream_wrapper_manager
   *   The stream wrapper manager service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(StreamWrapperManagerInterface $stream_wrapper_manager, ModuleHandlerInterface $module_handler) {
    $this->streamWrapperManager = $stream_wrapper_manager;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('stream_wrapper_manager'),
      $container->get('module_handler')
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

    // This functionality relies on image module being installed.
    if (!$this->moduleHandler->moduleExists('image')) {
      return $routes;
    }

    // Calling getWrappers() here returns an empty array here. Calling the
    // register method seems to resolve it.
    if (method_exists($this->streamWrapperManager, 'register')) {
      $this->streamWrapperManager->register();
    }

    // @todo Use the default scheme instead of hard-coding to public.
    $public_directory_path = $this->streamWrapperManager->getViaScheme('public')->getDirectoryPath();

    // Find all remote stream wrappers.
    $wrappers = $this->streamWrapperManager->getWrappers();
    $remote_wrappers = array_filter($wrappers, function($wrapper) {
      return file_is_wrapper_remote($wrapper['class']);
    });
    $remote_schemes = array_keys($remote_wrappers);

    foreach ($remote_schemes as $scheme) {
      // Manually specify the scheme so that the route is preferred over the
      // image.style_public route.
      $routes['image.style_' . $scheme] = new Route(
        '/' . $public_directory_path . '/styles/{image_style}/' . $scheme,
        array(
          '_controller' => 'Drupal\remote_stream_wrapper\Controller\RemoteImageStyleDownloadController::deliver',
          'scheme' => $scheme,
          '_disable_route_normalizer' => TRUE,
        ),
        array(
          '_access' => 'TRUE',
        )
      );
    }

    return $routes;
  }

}
