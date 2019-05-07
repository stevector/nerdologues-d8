<?php

namespace Drupal\remote_stream_wrapper\StreamWrapper;

use Drupal\Core\StreamWrapper\StreamWrapperInterface;

interface RemoteStreamWrapperInterface extends StreamWrapperInterface {

  /**
   * Refers to a remote file system location.
   *
   * @todo Investigate if we can rely on using this bit.
   */
  const REMOTE = 0x0002;

  /**
   * Visible and readable using remote files.
   */
  const REMOTE_NORMAL = 0x0016;

  /**
   * Perform an HTTP request for the current URI.
   *
   * @param string $method
   *   The HTTP method.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   The HTTP response object.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function request($method = 'GET');

}
