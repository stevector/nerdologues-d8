<?php

/**
 * @file
 * Contains \Drupal\field_group\Plugin\Derivative\FieldGroupLocalAction.
 */

namespace Drupal\field_group\Plugin\Derivative;

use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\field_ui\Plugin\Derivative\FieldUiLocalAction;

/**
 * Provides local action definitions for all entity bundles.
 */
class FieldGroupLocalAction extends FieldUiLocalAction implements ContainerDeriverInterface {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {

    $this->derivatives = array();

    foreach ($this->entityManager->getDefinitions() as $entity_type_id => $entity_type) {
      if ($entity_type->get('field_ui_base_route')) {

        $default_options = [
          'title' => $this->t('Add group'),
        ];

        $this->derivatives['field_group_add_' . $entity_type_id . '_form_display'] = [
          'route_name' => "field_ui.field_group_add_$entity_type_id.form_display",
          'appears_on' => [
            "entity.entity_form_display.{$entity_type_id}.default",
          ],
        ] + $default_options;

        $this->derivatives['field_group_add_' . $entity_type_id . '_form_display_form_mode'] = [
          'route_name' => "field_ui.field_group_add_$entity_type_id.form_display.form_mode",
          'appears_on' => [
            "entity.entity_form_display.{$entity_type_id}.form_mode",
          ],
        ] + $default_options;

        $this->derivatives['field_group_add_' . $entity_type_id . '_display'] = [
          'route_name' => "field_ui.field_group_add_$entity_type_id.display",
          'appears_on' => [
            "entity.entity_view_display.{$entity_type_id}.default",
          ],
        ] + $default_options;

        $this->derivatives['field_group_add_' . $entity_type_id . '_display_view_mode'] = [
          'route_name' => "field_ui.field_group_add_$entity_type_id.display.view_mode",
          'appears_on' => [
            "entity.entity_view_display.{$entity_type_id}.view_mode",
          ],
        ] + $default_options;
      }
    }

    foreach ($this->derivatives as &$entry) {
      $entry += $base_plugin_definition;
    }

    return $this->derivatives;
  }

}
