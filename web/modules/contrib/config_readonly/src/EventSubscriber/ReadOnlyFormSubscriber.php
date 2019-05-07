<?php

namespace Drupal\config_readonly\EventSubscriber;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Entity\EntityFormInterface;
use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\config_readonly\ReadOnlyFormEvent;
use Drupal\config_readonly\ConfigReadonlyWhitelistTrait;

/**
 * Check if the given form should be read-only.
 */
class ReadOnlyFormSubscriber implements EventSubscriberInterface {
  use ConfigReadonlyWhitelistTrait;

  /**
   * ReadOnlyFormSubscriber constructor.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke hooks.
   */
  public function __construct(ModuleHandlerInterface $module_handler) {
    $this->setModuleHandler($module_handler);
  }

  /**
   * Form ids to mark as read only.
   */
  protected $readOnlyFormIds = [
    'config_single_import_form',
    'system_modules',
    'system_modules_uninstall',
    'user_admin_permissions'
  ];

  /**
   * Form ids to skip marking as read only.
   */
  protected $formIdExceptions = [
    'search_form',
  ];

  /**
   * {@inheritdoc}
   */
  public function onFormAlter(ReadOnlyFormEvent $event) {
    // Check if the form is a ConfigFormBase or a ConfigEntityListBuilder.
    $form_object = $event->getFormState()->getFormObject();
    $mark_form_read_only = $form_object instanceof ConfigFormBase || $form_object instanceof ConfigEntityListBuilder;

    if (!$mark_form_read_only) {
      $mark_form_read_only = in_array($form_object->getFormId(), $this->readOnlyFormIds);
    }

    // Check if the form is an EntityFormInterface and entity is a config
    // entity.
    if (!$mark_form_read_only && $form_object instanceof EntityFormInterface) {
      $entity = $form_object->getEntity();
      $mark_form_read_only = $entity instanceof ConfigEntityInterface;
    }

    // Don't block particular patterns.
    if ($mark_form_read_only && $form_object instanceof EntityFormInterface) {
      $entity = $form_object->getEntity();
      $name = $entity->getConfigDependencyName();
      if ($this->matchesWhitelistPattern($name)) {
        $mark_form_read_only = FALSE;
      }
    }

    if ($mark_form_read_only && $form_object instanceof ConfigFormBase) {
      // Get the editable configuration names.
      $editable_config = $this->getEditableConfigNames($form_object);

      // If all editable config is in the whitelist, do not block the form.
      if ($editable_config == array_filter($editable_config, [$this, 'matchesWhitelistPattern'])) {
        $mark_form_read_only = FALSE;
      }
    }

    // Temporary exception to allow search form to being used until this core
    // issue is solved: https://www.drupal.org/node/2845743.
    if ($mark_form_read_only && in_array($form_object->getFormId(), $this->formIdExceptions)) {
      $mark_form_read_only = FALSE;
    }

    if ($mark_form_read_only) {
      $event->markFormReadOnly();
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];
    $events[ReadOnlyFormEvent::NAME][] = ['onFormAlter', 200];
    return $events;
  }

  /**
   * Get the editable configuration names.
   *
   * @param ConfigFormBase $form
   *   The configuration form.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   *
   * @see ConfigFormBaseTrait::getEditableConfigNames()
   */
  protected function getEditableConfigNames(ConfigFormBase $form) {
    // Use reflection to work around getEditableConfigNames() as protected.
    // @todo Review in 9.x for API change.
    // @see https://www.drupal.org/node/2095289
    $reflection = new \ReflectionMethod(get_class($form), 'getEditableConfigNames');
    $reflection->setAccessible(TRUE);
    return $reflection->invoke($form);
  }

}
