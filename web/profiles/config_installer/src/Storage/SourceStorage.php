<?php

/**
 * @file
 * Contains \Drupal\config_installer\Storage\SourceStorage.
 */

namespace Drupal\config_installer\Storage;

use Drupal\Core\Config\StorageInterface;
use Drupal\Core\DependencyInjection\DependencySerializationTrait;

/**
 * Wraps the sync storage so the config_installer can make modifications.
 */
class SourceStorage implements StorageInterface {
  use DependencySerializationTrait;

  /**
   * @var \Drupal\Core\Config\StorageInterface
   */
  protected $baseStorage;

  protected $profiles;

  /**
   * @param \Drupal\Core\Config\StorageInterface $base_storage
   */
  public function __construct(StorageInterface $base_storage, array $profiles) {
    $this->baseStorage = $base_storage;
    $this->profiles = $profiles;
  }

  /**
   * {@inheritdoc}
   */
  public function exists($name) {
    return $this->baseStorage->exists($name);
  }

  /**
   * {@inheritdoc}
   */
  public function read($name) {
    $data = $this->baseStorage->read($name);
    if ($name == 'core.extension' && isset($data['module'])) {
      // Remove any profiles from the list. These will be installed later.
      // @see config_installer_config_import_profile()
      $data['module'] = array_diff_key($data['module'], $this->profiles);
    }
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function readMultiple(array $names) {
    $list = array();
    foreach ($names as $name) {
      if ($data = $this->read($name)) {
        $list[$name] = $data;
      }
    }
    return $list;
  }

  /**
   * {@inheritdoc}
   */
  public function write($name, array $data) {
    return $this->baseStorage->write($name, $data);
  }

  /**
   * {@inheritdoc}
   */
  public function delete($name) {
    return $this->baseStorage->delete($name);
  }

  /**
   * {@inheritdoc}
   */
  public function rename($name, $new_name) {
    return $this->baseStorage->rename($name, $new_name);
  }

  /**
   * {@inheritdoc}
   */
  public function encode($data) {
    return $this->baseStorage->encode($data);
  }

  /**
   * {@inheritdoc}
   */
  public function decode($raw) {
    return $this->baseStorage->decode($raw);
  }

  /**
   * {@inheritdoc}
   */
  public function listAll($prefix = '') {
    return $this->baseStorage->listAll($prefix);
  }

  /**
   * {@inheritdoc}
   */
  public function deleteAll($prefix = '') {
    return $this->baseStorage->deleteAll($prefix);
  }

  /**
   * {@inheritdoc}
   */
  public function createCollection($collection) {
    return new static($this->baseStorage->createCollection($collection), $this->profiles);
  }

  /**
   * {@inheritdoc}
   */
  public function getAllCollectionNames() {
    return $this->baseStorage->getAllCollectionNames();
  }

  /**
   * {@inheritdoc}
   */
  public function getCollectionName() {
    return $this->baseStorage->getCollectionName();
  }
}
