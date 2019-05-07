<?php

namespace Drupal\Tests\remote_stream_wrapper\Kernel;

use Drupal\KernelTests\KernelTestBase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

/**
 * @coversDefaultClass \Drupal\remote_stream_wrapper\StreamWrapper\HttpStreamWrapper
 * @group remote_stream_wrapper
 */
class HttpStreamWrapperTest extends KernelTestBase {

  /**
   * @var \Drupal\remote_stream_wrapper\StreamWrapper\HttpStreamWrapper
   */
  protected $wrapper;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['remote_stream_wrapper'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->wrapper = $this->container->get('stream_wrapper.http');
  }

  /**
   * @covers ::stream_stat
   * @dataProvider dataStat
   */
  public function testStat($url, $expected_result, $head_response, $get_response) {
    $client = $this->prepareClient($url, $head_response, $get_response);
    $this->wrapper->setHttpClient($client);

    $stat = $this->wrapper->url_stat($url, 0);
    $this->assertStat($expected_result, $stat);
  }

  public function assertStat($expected_stat, $actual_stat) {
    if ($actual_stat && $expected_stat) {
      $actual_stat = array_intersect_key($actual_stat, $expected_stat);
    }
    $this->assertSame($expected_stat, $actual_stat);
  }

  public function dataStat() {
    $data = [];

    // HTTP request sends a 405 Method Not Allowed on HEAD.
    $data[] = [
      'http://www.drupal.org/',
      ['size' => 50],
      new ClientException(405, new Request('HEAD', ''), new Response(405)),
      new Response(200, ['Content-Length' => 50]),
    ];

    // HTTP request sends an empty HEAD response.
    $data[] = [
      'http://www.drupal.org/test',
      ['size' => 50],
      new Response(200),
      new Response(200, ['Content-Length' => 50]),
    ];

    // HTTP request sends a valid HEAD response.
    $data[] = [
      'http://www.drupal.org/test.unknown',
      ['size' => 25],
      new Response(200, ['Content-Length' => 25]),
      new Response(200, ['Content-Length' => 50]),
    ];

    // No Content-Type headers, rely on body size.

    $data[] = [
      'http://www.drupal.org/test.unknown',
      ['size' => 10],
      new Response(200),
      new Response(200, [], new Stream(fopen('php://temp', 'r'), ['size' => 10])),
    ];

    // Empty HEAD and GET responses.
    $data[] = [
      'https://www.drupal.org/',
      ['size' => 0],
      new Response(200),
      new Response(200),
    ];

    // Both HEAD and GET are error responses.
    $data[] = [
      'https://www.drupal.org/',
      NULL,
      new ClientException(404, new Request('HEAD', ''), new Response(404)),
      new ClientException(404, new Request('GET', ''), new Response(404)),
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
