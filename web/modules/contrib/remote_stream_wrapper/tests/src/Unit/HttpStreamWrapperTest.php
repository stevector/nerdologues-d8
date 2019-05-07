<?php

namespace Drupal\Tests\remote_stream_wrapper\Unit;

use Drupal\Core\StreamWrapper\StreamWrapperInterface;
use Drupal\remote_stream_wrapper\StreamWrapper\HttpStreamWrapper;
use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Client;

/**
 * @group remote_stream_wrapper
 * @coversDefaultClass \Drupal\remote_stream_wrapper\StreamWrapper\HttpStreamWrapper
 */
class HttpStreamWrapperTest extends UnitTestCase {

  /**
   * Test that the wrapper constants.
   *
   * @covers ::getType
   * @covers ::getName
   * @covers ::getDescription
   */
  public function testStreamConfiguration() {

    $type = HttpStreamWrapper::getType();
    $this->assertEquals(StreamWrapperInterface::READ & StreamWrapperInterface::HIDDEN, $type);
    $this->assertEquals($type & StreamWrapperInterface::LOCAL, 0);
    $this->assertNotEquals($type & StreamWrapperInterface::READ, 0);
    $this->assertEquals($type & StreamWrapperInterface::WRITE, 0);
    $this->assertEquals($type & StreamWrapperInterface::VISIBLE, 0);
    $this->assertNotEquals($type & StreamWrapperInterface::HIDDEN, 0);
    //$this->assertEquals($type & StreamWrapperInterface::LOCAL_HIDDEN, 0);
    //$this->assertEquals($type & StreamWrapperInterface::WRITE_VISIBLE, 0);
    $this->assertNotEquals($type & StreamWrapperInterface::READ_VISIBLE, 0);
    //$this->assertEquals($type & StreamWrapperInterface::NORMAL, 0);
    //$this->assertEquals($type & StreamWrapperInterface::LOCAL_NORMAL, 0);

    $wrapper = new HttpStreamWrapper(new Client());
    $this->assertInternalType('string', $wrapper->getName());
    $this->assertInternalType('string', $wrapper->getDescription());
  }

  /**
   * Test URI methods.
   *
   * @covers ::setUri
   * @covers ::getUri
   * @covers ::getExternalUrl
   * @covers ::realpath
   */
  public function testUri() {
    $wrapper = new HttpStreamWrapper();
    $uri = 'http://example.com/file.txt';
    $wrapper->setUri($uri);
    $this->assertEquals($uri, $wrapper->getUri());
    $this->assertEquals($uri, $wrapper->getExternalUrl());
    $this->assertEquals($uri, $wrapper->realpath());
  }

  /**
   * Test dirname().
   *
   * @covers ::dirname
   */
  public function testDirname() {
    $wrapper = new HttpStreamWrapper();

    // Test dirname() with no parameters.
    $wrapper->setUri('http://example.com/test.txt');
    $this->assertEquals('http://example.com', $wrapper->dirname());

    // Test dirname() with one directory.
    $wrapper->setUri('http://example.com/directory/test.txt');
    $this->assertEquals('http://example.com/directory', $wrapper->dirname());

    // Test dirname() with two directories and a $uri parameter.
    $this->assertEquals('http://example.com/directory/directory2', $wrapper->dirname('http://example.com/directory/directory2/test.txt'));

    // Test referencing self with a dot.
    $this->assertEquals('http://', $wrapper->dirname('http://.'));
  }

  /**
   * Test that we always return TRUE for locks.
   *
   * @covers ::stream_lock
   */
  public function testStreamLock() {
    $wrapper = new HttpStreamWrapper();
    $wrapper->setUri('http://example.com/test.txt');
    foreach ([LOCK_SH, LOCK_EX, LOCK_UN, LOCK_NB] as $type) {
      $this->assertTrue($wrapper->stream_lock($type));
    }
  }

  /**
   * Test that the timeout is set properly in configuration.
   *
   * @covers ::stream_set_option
   */
  public function testStreamSetOption() {
    $wrapper = new HttpStreamWrapper();
    $result = $wrapper->stream_set_option(STREAM_OPTION_READ_TIMEOUT, 30, 50);
    $this->assertTrue($result);
    $config = $wrapper->getHttpConfig();
    $this->assertEquals($config['timeout'], 30.000050);
  }

}
