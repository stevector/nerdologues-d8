<?php

namespace Drupal\Tests\remote_stream_wrapper\Kernel;

use Drupal\KernelTests\KernelTestBase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * @coversDefaultClass \Drupal\remote_stream_wrapper\File\MimeType\HttpMimeTypeGuesser
 * @group remote_stream_wrapper
 */
class HttpMimeTypeGuesserTest extends KernelTestBase {

  /**
   * @var \Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface
   */
  protected $guesser;

  /**
   * @var \Drupal\remote_stream_wrapper\File\MimeType\HttpMimeTypeGuesser
   */
  protected $httpGuesser;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['remote_stream_wrapper'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->guesser = $this->container->get('file.mime_type.guesser');
    $this->httpGuesser = $this->container->get('file.mime_type.guesser.http');
  }

  /**
   * Test the mime type guessing with various HTTP URLs.
   *
   * @covers ::parseFileNameFromUrl
   * @dataProvider dataParseFileNameFromUrl
   */
  public function testParseFileNameFromUrl($url, $expected_result) {
    $this->assertEquals($expected_result, $this->httpGuesser->parseFileNameFromUrl($url));
  }

  /**
   * Test the mime type guessing with various HTTP URLs.
   *
   * @covers ::guess
   * @dataProvider dataHttpMimetypeGuessing
   */
  public function testHttpMimeTypeGuessing($url, $expected_result, $head_response = NULL, $get_response = NULL) {
    $client = $this->prepareClient($url, $head_response, $get_response);
    $this->httpGuesser->setHttpClient($client);

    $this->assertEquals($expected_result, $this->guesser->guess($url));
  }

  public function dataParseFileNameFromUrl() {
    return [
      ['http://www.example.com/file.txt', 'file.txt'],
      // Test adding query strings and fragments which should be ignored.
      ['http://www.example.com/test/file.txt.pdf?extension=.gif', 'file.txt.pdf'],
      ['http://www.example.com/FILE.PDF#foo', 'FILE.PDF'],
      ['http://www.example.com/', NULL],
      ['http://www.example.com/test', NULL],
      ['//www.example.com/test.unknown', 'test.unknown'],
    ];
  }

  public function dataHttpMimetypeGuessing() {
    $data = [];

    // Filename can be extracted from URL, no HTTP requests.
    $data[] = [
      'http://www.drupal.org/file.txt',
      'text/plain',
    ];

    // Test adding query strings and fragments which should be ignored.
    $data[] = [
      'http://www.drupal.org/test/file.txt?extension=.gif',
      'text/plain',
    ];
    $data[] = [
      'https://www.drupal.org/FILE.PDF#foo',
      'application/pdf',
    ];

    // HTTP request sends a 405 Method Not Allowed on HEAD.
    $data[] = [
      'http://www.drupal.org/',
      'html/get',
      new ClientException(405, new Request('HEAD', ''), new Response(405)),
      new Response(200, ['Content-Type' => 'html/get']),
    ];

    // HTTP request sends an empty HEAD response.
    $data[] = [
      'http://www.drupal.org/test',
      'html/get',
      new Response(200),
      new Response(200, ['Content-Type' => 'html/get']),
    ];

    // HTTP request sends a valid HEAD response.
    $data[] = [
      '//www.drupal.org/test.unknown',
      'html/head',
      new Response(200, ['Content-Type' => 'html/head']),
      new Response(200, ['Content-Type' => 'html/get']),
    ];

    // Both HEAD and GET are error responses.
    $data[] = [
      'https://www.drupal.org/',
      'application/octet-stream',
      new ClientException(404, new Request('HEAD', ''), new Response(404)),
      new ClientException(404, new Request('GET', ''), new Response(404)),
    ];

    // Non-HTTP URLs should bypass the HTTP guesser.
    $data[] = [
      'public://test.unknown',
      'application/octet-stream',
      new Response(200, ['Content-Type' => 'html/head']),
    ];
    $data[] = [
      'core/CHANGELOG.txt',
      'text/plain',
      new Response(200, ['Content-Type' => 'html/head']),
    ];

    return $data;
  }

  /**
   * Prepare the mock HTTP requests and responses.
   *
   * @param $url
   * @param $head_response
   * @param $get_response
   *
   * @return \GuzzleHttp\ClientInterface
   */
  protected function prepareClient($url, $head_response, $get_response) {
    $client = $this->prophesize('\GuzzleHttp\Client');
    if ($head_response instanceof Response) {
      $client->request('HEAD', $url, [])->willReturn($head_response);
    }
    elseif ($head_response instanceof \Exception) {
      $client->request('HEAD', $url, [])->willThrow($head_response);
    }
    if ($get_response instanceof Response) {
      $client->request('GET', $url, [])->willReturn($get_response);
    }
    elseif ($get_response instanceof \Exception) {
      $client->request('GET', $url, [])->willThrow($get_response);
    }
    return $client->reveal();
  }

}
