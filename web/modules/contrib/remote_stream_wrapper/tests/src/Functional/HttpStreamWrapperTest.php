<?php


namespace Drupal\Tests\remote_stream_wrapper\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Core\Url;

/**
 * @group remote_stream_wrapper
 *
 * @runTestsInSeparateProcesses
 *
 * @preserveGlobalState disabled
 */
class HttpStreamWrapperTest extends BrowserTestBase {

  public static $modules = ['remote_stream_wrapper'];

  public function testFileSize() {
    $uri = $this->getAbsoluteUrl('core/CHANGELOG.txt');
    $this->assertEquals(filesize('core/CHANGELOG.txt'), filesize($uri));
  }

  public function testReadStream() {
    $uri = $this->getAbsoluteUrl('core/CHANGELOG.txt');
    $contents = file_get_contents($uri);
    $contents_from_local = file_get_contents('core/CHANGELOG.txt');
    $this->assertEquals($contents_from_local, $contents);
  }

  /**
   * Test the mime type guessing with various HTTP URLs.
   */
  public function testHttpMimeTypeGuessing() {
    /** @var \Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface $guesser */
    $guesser = \Drupal::service('file.mime_type.guesser');

    // URL exists and has a valid extension.
    $url = Url::fromUri('base:CHANGELOG.txt', ['absolute' => TRUE])->toString();
    $this->assertEquals($guesser->guess($url), 'text/plain');

    // URL does not actually exist, but has a valid extension.
    $url = Url::fromUri('base:CHANGELOG.pdf', ['absolute' => TRUE])->toString();
    $this->assertEquals($guesser->guess($url), 'application/pdf');

    // URL contains a query string.
    $url = Url::fromUri('base:CHANGELOG.txt', ['absolute' => TRUE, 'query' => ['extension' => '.gif']])->toString();
    $this->assertEquals($guesser->guess($url), 'text/plain');

    // URL without an extension, should fetch from the Content-Type header.
    $url = 'http://www.example.com/';
    $this->assertEquals($guesser->guess($url), 'text/html');
  }

}
