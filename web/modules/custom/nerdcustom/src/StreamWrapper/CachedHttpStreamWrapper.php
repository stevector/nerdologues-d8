<?php

/**
 * @file
 * Statically cache file sizes during a migration.
 */

namespace Drupal\nerdcustom\StreamWrapper;

use Drupal\Core\StreamWrapper\StreamWrapperInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Drupal\remote_stream_wrapper\StreamWrapper\HttpStreamWrapper;
use Drupal\Core\Database\Database;

/**
 * HTTP(s) stream wrapper.
 */
class CachedHttpStreamWrapper extends HttpStreamWrapper {

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
    $files = &drupal_static(__METHOD__, array());

    if (empty($files) && function_exists('drush_print') && !empty(Database::getConnectionInfo('drupal_7'))) {
      drush_print("Loading all files from Drupal 7 database");
      $files = [];
      $results = Database::getConnection('default', 'drupal_7')
        ->select('file_managed')
        ->fields('file_managed')->execute();

       foreach ($results as $result) {
         $files[$result->uri] = [
           'size' => $result->filesize,
           'mtime' => $result->timestamp
         ];
      }
    }

    if (!empty($files[$this->uri])) {
      $stat =  $files[$this->uri] + $stat;
      return $stat;
    }
    else {
      return parent::stream_stat();
    }
  }
}
