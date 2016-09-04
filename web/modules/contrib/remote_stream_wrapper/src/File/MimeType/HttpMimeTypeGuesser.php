<?php

namespace Drupal\remote_stream_wrapper\File\MimeType;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface;

class HttpMimeTypeGuesser implements MimeTypeGuesserInterface {

  /**
   * The stream wrapper manager.
   *
   * @var \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface
   */
  protected $streamWrapperManager;

  /**
   * The file system.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The extension guesser.
   *
   * @var \Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface
   */
  protected $extensionGuesser;

  /**
   * Constructs a new HttpMimeTypeGuesser.
   *
   * @param \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $stream_wrapper_manager
   *   The stream wrapper manager.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system.
   * @param \Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface $extension_guesser
   *   The extension guesser.
   */
  public function __construct(StreamWrapperManagerInterface $stream_wrapper_manager, FileSystemInterface $file_system, MimeTypeGuesserInterface $extension_guesser) {
    $this->streamWrapperManager = $stream_wrapper_manager;
    $this->fileSystem = $file_system;
    $this->extensionGuesser = $extension_guesser;
  }

  /**
   * {@inheritdoc}
   */
  public function guess($path) {
    if (!$this->fileIsUriRemote($path)) {
      return NULL;
    }

    // Attempt to parse out the mime type if the URL contains a filename.
    if ($filename = $this->fileSystem->basename(parse_url($path, PHP_URL_PATH))) {
      // Filename must contain a period in order to find a valid extension.
      // If the filename does not contain an extension, then guess() will
      // always return the default 'application/octet-stream' value.
      if (strpos($filename, '.') !== FALSE) {
        $mimetype = $this->extensionGuesser->guess($filename);
        if ($mimetype != 'application/octet-stream') {
          // Only return the guessed mime type if it found a valid match
          // instead of returning the default mime type.
          return $mimetype;
        }
      }
    }

    try {
      /** @var \Drupal\remote_stream_wrapper\StreamWrapper\RemoteStreamWrapperInterface $wrapper */
      $wrapper = $this->streamWrapperManager->getViaUri($path);
      $response = $wrapper->requestTryHeadLookingForHeader('Content-Type');
      if ($response->hasHeader('Content-Type')) {
        return $response->getHeaderLine('Content-Type');
      }
    }
    catch (\Exception $exception) {
      watchdog_exception('remote_stream_wrapper', $exception);
    }

    return NULL;
  }

  /**
   * Provides a wrapper for file_is_uri_remote() to allow unit testing.
   *
   * @todo: Convert file_is_uri_remote() into a proper injectable service.
   *
   * @param string $uri
   *   A file URI.
   *
   * @return bool
   *   TRUE if the file is remote, or FALSE otherwise.
   */
  public function fileIsUriRemote($uri) {
    return file_is_uri_remote($uri);
  }

}
