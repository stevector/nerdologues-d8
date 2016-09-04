<?php

namespace Drupal\remote_stream_wrapper\StreamWrapper;

/**
 * Trait that contains all unimplemented methods.
 *
 * This trait should only contain methods defined in
 * \Drupal\Core\StreamWrapper\PhpStreamWrapperInterface.
 *
 * @see \Drupal\Core\StreamWrapper\ReadOnlyStream
 *
 * @codeCoverageIgnore
 *  Since these are all FALSE returns, we don't bother to unit test them.
 *
 * @codingStandardsIgnoreStart
 */


trait ReadOnlyPhpStreamWrapperTrait {

  /**
   * {@inheritdoc}
   */
  public function dir_closedir() {
    trigger_error('dir_closedir() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function dir_opendir($path, $options) {
    trigger_error('dir_opendir() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function dir_readdir() {
    trigger_error('dir_readdir() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function dir_rewinddir() {
    trigger_error('dir_rewinddir() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function mkdir($path, $mode, $options) {
    trigger_error('mkdir() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function rename($path_from, $path_to) {
    trigger_error('rename() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function rmdir($path, $options) {
    trigger_error('rmdir() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_cast($cast_as) {
    trigger_error('stream_cast() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * Support for fflush().
   *
   * Nothing will be output to the file, as this is a read-only stream wrapper.
   * However as stream_flush is called during stream_close we should not trigger
   * an error.
   *
   * @return bool
   *   FALSE, as no data will be stored.
   *
   * @see http://php.net/manual/streamwrapper.stream-flush.php
   */
  public function stream_flush() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_metadata($path, $option, $value) {
    trigger_error('stream_metadata() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_truncate($new_size) {
    trigger_error('stream_truncate() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function stream_write($data) {
    trigger_error('stream_write() not supported for HTTP stream wrappers', E_USER_WARNING);
    return FALSE;
  }

  /**
   * Support for unlink().
   *
   * The file will not be deleted from the stream as this is a HTTP stream
   * wrapper.
   *
   * @param string $path
   *   A string containing the uri to the resource to delete.
   *
   * @return bool
   *   TRUE so that file_delete() will remove db reference to file. File is not
   *   actually deleted.
   *
   * @see http://php.net/manual/streamwrapper.unlink.php
   */
  public function unlink($path) {
    trigger_error('unlink() not supported for HTTP stream wrappers', E_USER_WARNING);
    return TRUE;
  }

}
