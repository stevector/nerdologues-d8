#!/usr/bin/bash
./bin/phpcs --report=full --extensions=php,module,inc,theme,info --standard=vendor/drupal/coder/coder_sniffer/Drupal/  ../../modules/custom 

