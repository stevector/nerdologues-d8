<?php

namespace Drupal\nerdcustom\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Plugin\Field\FieldWidget\UriWidget;

/**
 * Plugin implementation of the 'remote uri' widget.
 *
 * @FieldWidget(
 *   id = "nerd_remote_uri",
 *   label = @Translation("Remote URI field"),
 *   field_types = {
 *     "file",
 *   }
 * )
 */
class RemoteUriWidget extends UriWidget {

}
