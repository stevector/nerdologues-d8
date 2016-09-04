<?php

namespace Drupal\nerdcustom;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

class NerdCustomServiceProvider extends ServiceProviderBase {

  public function alter(ContainerBuilder $container) {
    
    
    
    print_r("        asdf       ");
    
    
    // Overrides language_manager class to test domain language negotiation.
    $definition = $container->getDefinition('stream_wrapper.http');
    $definition->setClass('\Drupal\nerdcustom\StreamWrapper\CachedHttpStreamWrapper');
  }
}
?>
