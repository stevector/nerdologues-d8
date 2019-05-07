<?php

namespace Drupal\remote_stream_wrapper\StreamWrapper;

use Drupal\Core\StreamWrapper\StreamWrapperInterface;
use Drupal\remote_stream_wrapper\HttpClientTrait;

require_once 'modules/contrib/remote_stream_wrapper/src/StreamWrapper/RemoteStreamWrapperInterface.php';
require_once 'modules/contrib/remote_stream_wrapper/src/StreamWrapper/ReadOnlyPhpStreamWrapperTrait.php';
require_once 'modules/contrib/remote_stream_wrapper/src/HttpClientTrait.php';

/**
 * HTTP(s) stream wrapper.
 */
class HttpStreamWrapper implements RemoteStreamWrapperInterface {
  use ReadOnlyPhpStreamWrapperTrait;
  use HttpClientTrait;

  /**
   * The URI of the resource.
   *
   * @var string
   */
  protected $uri;

  /**
   * The response stream.
   *
   * @var \Psr\Http\Message\StreamInterface
   */
  protected $stream;

  /**
   * Optional configuration for HTTP requests.
   *
   * @var array
   */
  protected $config = [];

  /**
   * {@inheritdoc}
   */
  public static function getType() {
    return StreamWrapperInterface::READ & StreamWrapperInterface::HIDDEN;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'HTTP stream wrapper';
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'HTTP stream wrapper';
  }

  /**
   * {@inheritdoc}
   */
  public function setUri($uri) {
    $this->uri = $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function getUri() {
    return $this->uri;
  }

  /**
   * {@inheritdoc}
   */
  public function getExternalUrl() {
    return $this->uri;
  }

  /**
   * {@inheritdoc}
   */
  public function realpath() {
    return $this->uri;
  }

  /**
   * {@inheritdoc}
   */
  public function dirname($uri = NULL) {
    if (!isset($uri)) {
      $uri = $this->uri;
    }

    list($scheme, $target) = explode('://', $uri, 2);
    $dirname = dirname($target);

    if ($dirname == '.') {
      $dirname = '';
    }

    return $scheme . '://' . $dirname;
  }

  /**
   * {@inheritdoc}
   *
   * @codeCoverageIgnore
   */
  public function stream_close() {
    // Nothing to do when closing an HTTP stream.
  }

  /**
   * {@inheritdoc}
   */
  public function stream_eof() {
    return $this->stream->eof();
  }

  /**
   * {@inheritdoc}
   */
  public function stream_lock($operation) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_open($path, $mode, $options, &$opened_path) {
    if (!in_array($mode, array('r', 'rb', 'rt'))) {
      if ($options & STREAM_REPORT_ERRORS) {
        trigger_error('stream_open() write modes not supported for HTTP stream wrappers', E_USER_WARNING);
      }
      return FALSE;
    }

    try {
      $this->setUri($path);
      $this->request();
    }
    catch (\Exception $e) {
      if ($options & STREAM_REPORT_ERRORS) {
        // TODO: Make this testable.
        watchdog_exception('remote_stream_wrapper', $e);
      }
      return FALSE;
    }

    if ($options & STREAM_USE_PATH) {
      $opened_path = $path;
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_read($count) {
    return $this->stream->read($count);
  }

  /**
   * {@inheritdoc}
   */
  public function stream_seek($offset, $whence = SEEK_SET) {
    try {
      $this->stream->seek($offset, $whence);
    } catch (\RuntimeException $e) {
      // TODO Make this testable.
      watchdog_exception('remote_stream_wrapper', $e);
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Change stream options.
   *
   * This method is called to set options on the stream.
   *
   * @param int $option
   *   One of:
   *   - STREAM_OPTION_BLOCKING: The method was called in response to
   *     stream_set_blocking().
   *   - STREAM_OPTION_READ_TIMEOUT: The method was called in response to
   *     stream_set_timeout().
   *   - STREAM_OPTION_WRITE_BUFFER: The method was called in response to
   *     stream_set_write_buffer().
   * @param int $arg1
   *   If option is:
   *   - STREAM_OPTION_BLOCKING: The requested blocking mode:
   *     - 1 means blocking.
   *     - 0 means not blocking.
   *   - STREAM_OPTION_READ_TIMEOUT: The timeout in seconds.
   *   - STREAM_OPTION_WRITE_BUFFER: The buffer mode, STREAM_BUFFER_NONE or
   *     STREAM_BUFFER_FULL.
   * @param int $arg2
   *   If option is:
   *   - STREAM_OPTION_BLOCKING: This option is not set.
   *   - STREAM_OPTION_READ_TIMEOUT: The timeout in microseconds.
   *   - STREAM_OPTION_WRITE_BUFFER: The requested buffer size.
   *
   * @return bool
   *   TRUE on success, FALSE otherwise. If $option is not implemented, FALSE
   *   should be returned.
   */
  public function stream_set_option($option, $arg1, $arg2) {
    if ($option != STREAM_OPTION_READ_TIMEOUT) {
      return FALSE;
    }

    $this->config['timeout'] = $arg1 + ($arg2 / 1000000);
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_stat() {
    // @see https://github.com/guzzle/psr7/blob/master/src/StreamWrapper.php
    $stat = [
      'dev' => 0,               // device number
      'ino' => 0,               // inode number
      'mode' => 0100000 | 0444, // inode protection (regular file + read only)
      'nlink' => 0,             // number of links
      'uid' => 0,               // userid of owner
      'gid' => 0,               // groupid of owner
      'rdev' => 0,              // device type, if inode device *
      'size' => 0,              // size in bytes
      'atime' => 0,             // time of last access (Unix timestamp)
      'mtime' => 0,             // time of last modification (Unix timestamp)
      'ctime' => 0,             // time of last inode change (Unix timestamp)
      'blksize' => 0,           // blocksize of filesystem IO
      'blocks' => 0,            // number of blocks allocated
    ];

    try {
      $response = $this->requestTryHeadLookingForHeader($this->uri, 'Content-Length', $this->config);

      if ($response->hasHeader('Content-Length')) {
        $stat['size'] = (int) $response->getHeaderLine('Content-Length');
      }
      elseif ($size = $response->getBody()->getSize()) {
        $stat['size'] = $size;
      }
      if ($response->hasHeader('Last-Modified')) {
        if ($mtime = strtotime($response->getHeaderLine('Last-Modified'))) {
          $stat['mtime'] = $mtime;
        }
      }

      return $stat;
    }
    catch (\Exception $exception) {
      watchdog_exception('remote_stream_wrapper', $exception);
      return NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function stream_tell() {
    return $this->stream->tell();
  }

  /**
   * {@inheritdoc}
   */
  public function url_stat($path, $flags) {
    $this->setUri($path);
    if ($flags & STREAM_URL_STAT_QUIET) {
      return @$this->stream_stat();
    }
    else {
      return $this->stream_stat();
    }
  }

  /**
   * Returns the current HTTP client configuration.
   *
   * @return array
   */
  public function getHttpConfig() {
    return $this->config;
  }

  /**
   * {@inheritdoc}
   */
  public function request($method = 'GET') {
    $response = $this->getHttpClient()->request($method, $this->uri, $this->config);
    if ($method !== 'HEAD') {
      $this->stream = $response->getBody();
    }
    return $response;
  }

}
