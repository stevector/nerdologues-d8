<?php

namespace Drupal\remote_stream_wrapper;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Trait to help reuse HTTP client logic.
 */
trait HttpClientTrait {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Sets the HTTP client.
   *
   * @param \GuzzleHttp\ClientInterface $client
   *   An HTTP client.
   */
  public function setHttpClient(ClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * Returns the HTTP client.
   *
   * @return \GuzzleHttp\ClientInterface
   */
  public function getHttpClient() {
    if (!isset($this->httpClient)) {
      $this->httpClient = \Drupal::httpClient();
    }
    return $this->httpClient;
  }

  /**
   * Perform a HEAD/GET request looking for a specific header.
   *
   * If the header was found in the HEAD request, then the HEAD response is
   * returned. Otherwise the GET request response is returned (without checking
   * if the header was found).
   *
   * @param string $uri
   * @param string $header
   *   Case-insensitive header field name.
   * @param array $options
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   The HTTP response object.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function requestTryHeadLookingForHeader($uri, $header, array $options = []) {
    try {
      $response = $this->getHttpClient()->request('HEAD', $uri, $options);
      if ($response->hasHeader($header)) {
        return $response;
      }
    }
    catch (ClientException $exception) {
      // Do nothing, try a GET request instead.
    }
    catch (ServerException $exception) {
      // Do nothing, try a GET request instead.
    }

    return $this->getHttpClient()->request('GET', $uri, $options);
  }

}
