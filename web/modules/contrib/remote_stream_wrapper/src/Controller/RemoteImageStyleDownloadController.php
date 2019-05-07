<?php

namespace Drupal\remote_stream_wrapper\Controller;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Image\ImageFactory;
use Drupal\Core\Lock\LockBackendInterface;
use Drupal\image\Controller\ImageStyleDownloadController;
use Drupal\image\ImageStyleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

require_once "core/modules/image/src/Controller/ImageStyleDownloadController.php";

/**
 * Defines a controller to serve image styles.
 */
class RemoteImageStyleDownloadController extends ImageStyleDownloadController {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $fileStorage;

  /**
   * Constructs a RemoteImageStyleDownloadController object.
   *
   * @param \Drupal\Core\Lock\LockBackendInterface $lock
   *   The lock backend.
   * @param \Drupal\Core\Image\ImageFactory $image_factory
   *   The image factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(LockBackendInterface $lock, ImageFactory $image_factory, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($lock, $image_factory);
    $this->fileStorage = $entity_type_manager->getStorage('file');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('lock'),
      $container->get('image.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function deliver(Request $request, $scheme, ImageStyleInterface $image_style) {
    // Only allow the remote files that exist in {file_managed} to have image
    // style derivatives generated. Otherwise this could open up the site to
    // allowing any remote file to be processed.
    $target = $request->query->get('file');
    $image_uri = $scheme . '://' . $target;
    if (!$this->fileStorage->loadByProperties(['uri' => $image_uri])) {
      throw new AccessDeniedHttpException();
    }

    return parent::deliver($request, $scheme, $image_style);
  }

}
