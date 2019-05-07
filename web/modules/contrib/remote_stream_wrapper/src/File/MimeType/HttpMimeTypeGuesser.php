<?php

namespace Drupal\remote_stream_wrapper\File\MimeType;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\File\FileSystemInterface;
use Drupal\remote_stream_wrapper\HttpClientTrait;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface;

class HttpMimeTypeGuesser implements MimeTypeGuesserInterface {
  use HttpClientTrait;

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
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system.
   * @param \Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface $extension_guesser
   *   The extension guesser.
   */
  public function __construct(FileSystemInterface $file_system, MimeTypeGuesserInterface $extension_guesser) {
    $this->fileSystem = $file_system;
    $this->extensionGuesser = $extension_guesser;
  }

  /**
   * {@inheritdoc}
   */
  public function guess($path) {
    // Ignore non-external URLs.
    if (!UrlHelper::isExternal($path)) {
      return NULL;
    }

    // Attempt to parse out the mime type if the URL contains a filename.
    if ($filename = $this->parseFileNameFromUrl($path)) {
      $mimetype = $this->extensionGuesser->guess($filename);
      if ($mimetype != 'application/octet-stream') {
        // Only return the guessed mime type if it found a valid match
        // instead of returning the default mime type.
        return $mimetype;
      }
    }

    try {
      $response = $this->requestTryHeadLookingForHeader($path, 'Content-Type');
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
   * Parse a file name from a URI.
   *
   * This also requires the filename to have an extension.
   *
   * @param string $uri
   *   The URI.
   *
   * @return string|null
   *   The filename if it could be parsed from the URI, or NULL otherwise.
   */
  public function parseFileNameFromUrl($uri) {
    // Extract the path part from the URL, ignoring query strings or fragments.
    if ($path = parse_url($uri, PHP_URL_PATH)) {
      $filename = $this->fileSystem->basename($path);
      // Filename must contain a period in order to find a valid extension.
      // If the filename does not contain an extension, then guess() will
      // always return the default 'application/octet-stream' value.
      if (strpos($filename, '.') > 0) {
        return $filename;
      }
    }
  }

}
