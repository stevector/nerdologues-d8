<?php

namespace Drupal\cdn;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigValueException;

/**
 * Wraps the CDN settings configuration, contains all parsing.
 *
 * @internal
 */
class CdnSettings {

  /**
   * The CDN settings.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $rawSettings;

  /**
   * The lookup table.
   *
   * @var array|null
   */
  protected $lookupTable;

  /**
   * Constructs a new CdnSettings object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->rawSettings = $config_factory->get('cdn.settings');
    $this->lookupTable = NULL;
  }

  /**
   * @return bool
   */
  public function isEnabled() {
    return $this->rawSettings->get('status') === TRUE;
  }

  /**
   * @return bool
   */
  public function farfutureIsEnabled() {
    return $this->rawSettings->get('farfuture.status') === TRUE;
  }

  /**
   * Returns the lookup table.
   *
   * @return array
   *   A lookup table. Keys are lowercase file extensions or the asterisk.
   *   Values are CDN domains (either string if only one, or array of strings if
   *   multiple).
   */
  public function getLookupTable() {
    if ($this->lookupTable === NULL) {
      $this->lookupTable = $this->buildLookupTable($this->rawSettings->get('mapping'));
    }
    return $this->lookupTable;
  }

  /**
   * Returns all unique CDN domains that are configured.
   *
   * @return string[]
   */
  public function getDomains() {
    $flattened = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->getLookupTable())), FALSE);
    $unique_domains = array_unique(array_filter($flattened));
    return $unique_domains;
  }

  /**
   * Builds a lookup table: file extension to CDN domain(s).
   *
   * @param array $mapping
   *   An array matching either of the mappings in cdn.mapping.schema.yml.
   *
   * @return array
   *   A lookup table. Keys are lowercase file extensions or the asterisk.
   *   Values are CDN domains (either string if only one, or array of strings if
   *   multiple).
   *
   * @throws \Drupal\Core\Config\ConfigValueException
   *
   * @todo Abstract this out further in the future if the need arises, i.e. if
   *       more conditions besides extensions are added. For now, KISS.
   */
  protected function buildLookupTable(array $mapping) {
    $lookup_table = [];
    if ($mapping['type'] === 'simple') {
      $domain = $mapping['domain'];
      assert('\Drupal\cdn\CdnSettings::isValidCdnDomain($domain)', "The provided domain $domain is not valid. Provide a host like 'cdn.com' or 'cdn.example.com'. IP addresses and ports are also allowed.");
      if (empty($mapping['conditions'])) {
        $lookup_table['*'] = $domain;
      }
      else {
        if (empty($mapping['conditions']['extensions'])) {
          $lookup_table['*'] = $domain;
        }
        else {
          foreach ($mapping['conditions']['extensions'] as $extension) {
            $lookup_table[$extension] = $domain;
          }
        }

        if (isset($mapping['conditions']['not'])) {
          assert('!isset($mapping[\'conditions\'][\'extensions\'])', 'It does not make sense to provide an \'extensions\' condition as well as a negated \'extensions\' condition.');
          if (!empty($mapping['conditions']['not']['extensions'])) {
            foreach ($mapping['conditions']['not']['extensions'] as $not_extension) {
              $lookup_table[$not_extension] = FALSE;
            }
          }
        }
      }
    }
    elseif ($mapping['type'] === 'complex') {
      $fallback_domain = NULL;
      if (isset($mapping['fallback_domain'])) {
        $fallback_domain = $mapping['fallback_domain'];
        assert('\Drupal\cdn\CdnSettings::isValidCdnDomain($fallback_domain)', "The provided fallback domain $fallback_domain is not valid. Provide a host like 'cdn.com' or 'cdn.example.com'. IP addresses and ports are also allowed.");
        $lookup_table['*'] = $fallback_domain;
      }
      for ($i = 0; $i < count($mapping['domains']); $i++) {
        $nested_mapping = $mapping['domains'][$i];
        assert('!empty($nested_mapping[\'conditions\'])', 'The nested mapping ' . $i . ' includes no conditions, which is not allowed for complex mappings.');
        assert('!isset($nested_mapping[\'conditions\'][\'not\'])', 'The nested mapping ' . $i . ' includes negated conditions, which is not allowed for complex mappings: the fallback_domain already serves this purpose.');
        $lookup_table += $this->buildLookupTable($nested_mapping);
      }
    }
    elseif ($mapping['type'] === 'auto-balanced') {
      if (empty($mapping['conditions']) || empty($mapping['conditions']['extensions'])) {
        throw new ConfigValueException('It does not make sense to apply auto-balancing to all files, regardless of extension.');
      }
      $domains = $mapping['domains'];
      foreach ($domains as $domain) {
        assert('\Drupal\cdn\CdnSettings::isValidCdnDomain($domain)', "The provided domain $domain is not valid. Provide a host like 'cdn.com' or 'cdn.example.com'. IP addresses and ports are also allowed.");
      }
      foreach ($mapping['conditions']['extensions'] as $extension) {
        $lookup_table[$extension] = $domains;
      }
    }
    else {
      throw new ConfigValueException('Unknown CDN mapping type specified.');
    }
    return $lookup_table;
  }

  /**
   * Validates the given CDN domain.
   *
   * @param string $domain
   *   A domain as expected by the CDN module. In fact, an "authority" as
   *   defined in RFC3986. An authority consists of host, optional userinfo and
   *   optional port. The host can be an IP address or registered domain name.
   *
   * @return bool
   *
   * @see https://tools.ietf.org/html/rfc3986#section-3.2
   * @see ../config/schema/cdn.data_types.schema.yml
   */
  public static function isValidCdnDomain($domain) {
    // Add a scheme so that we have a parseable URL.
    $url = 'https://' . $domain;
    $components = parse_url($url);

    $forbidden_components = ['path', 'query', 'fragment'];
    return $components === FALSE ? FALSE : empty(array_intersect($forbidden_components, array_keys($components)));
  }

}
