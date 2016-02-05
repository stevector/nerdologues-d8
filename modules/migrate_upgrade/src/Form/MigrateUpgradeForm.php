<?php

/**
 * @file
 * Contains \Drupal\migrate_upgrade\Form\MigrateUpgradeForm.
 */

namespace Drupal\migrate_upgrade\Form;

use Drupal\Core\Form\ConfirmFormHelper;
use Drupal\Core\Form\ConfirmFormInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\migrate\Entity\Migration;
use Drupal\migrate\Entity\MigrationInterface;
use Drupal\migrate_upgrade\MigrationCreationTrait;

/**
 * Multi-step form for performing direct site upgrades.
 */
class MigrateUpgradeForm extends FormBase implements ConfirmFormInterface {

  use MigrationCreationTrait;

  /**
   * The choices of what to do when an upgrade has previously been run.
   */
  const MIGRATE_UPGRADE_INCREMENTAL = 1;
  const MIGRATE_UPGRADE_ROLLBACK = 2;

  /**
   * @todo: Find a mechanism to derive this information from the migrations
   *   themselves.
   *
   * @var array
   */
  protected $moduleUpgradePaths = [
    'd6_action_settings' => [
      'source_module' => 'system',
      'destination_module' => 'action'
    ],
    'd6_aggregator_feed' => [
      'source_module' => 'aggregator',
      'destination_module' => 'aggregator',
    ],
    'd6_aggregator_item' => [
      'source_module' => 'aggregator',
      'destination_module' => 'aggregator',
    ],
    'd6_aggregator_settings' => [
      'source_module' => 'aggregator',
      'destination_module' => 'aggregator',
    ],
    'd7_aggregator_feed' => [
      'source_module' => 'aggregator',
      'destination_module' => 'aggregator',
    ],
    'd7_aggregator_item' => [
      'source_module' => 'aggregator',
      'destination_module' => 'aggregator',
    ],
    'd7_aggregator_settings' => [
      'source_module' => 'aggregator',
      'destination_module' => 'aggregator',
    ],
    'd7_blocked_ips' => [
      'source_module' => 'system',
      'destination_module' => 'ban',
    ],
    'd6_block' => [
      'source_module' => 'block',
      'destination_module' => 'block',
    ],
    'd7_block' => [
      'source_module' => 'block',
      'destination_module' => 'block',
    ],
    'block_content_body_field' => [
      'source_module' => 'block',
      'destination_module' => 'block_content',
    ],
    'block_content_type' => [
      'source_module' => 'block',
      'destination_module' => 'block_content',
    ],
    'd6_custom_block' => [
      'source_module' => 'block',
      'destination_module' => 'block_content',
    ],
    'd7_custom_block' => [
      'source_module' => 'block',
      'destination_module' => 'block_content',
    ],
    'd6_book' => [
      'source_module' => 'book',
      'destination_module' => 'book',
    ],
    'd6_book_settings' => [
      'source_module' => 'book',
      'destination_module' => 'book',
    ],
    'd6_comment' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd6_comment_entity_display' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd6_comment_entity_form_display' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd6_comment_entity_form_display_subject' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd6_comment_field' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd6_comment_field_instance' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd6_comment_type' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment_entity_display' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment_entity_form_display' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment_entity_form_display_subject' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment_field' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment_field_instance' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'd7_comment_type' => [
      'source_module' => 'comment',
      'destination_module' => 'comment',
    ],
    'contact_category' => [
      'source_module' => 'contact',
      'destination_module' => 'contact',
    ],
    'd6_contact_settings' => [
      'source_module' => 'contact',
      'destination_module' => 'contact',
    ],
    'd7_contact_settings' => [
      'source_module' => 'contact',
      'destination_module' => 'contact',
    ],
    'd6_dblog_settings' => [
      'source_module' => 'dblog',
      'destination_module' => 'dblog',
    ],
    'd7_dblog_settings' => [
      'source_module' => 'dblog',
      'destination_module' => 'dblog',
    ],
    'd6_field' => [
      'source_module' => 'content',
      'destination_module' => 'field',
    ],
    'd6_field_formatter_settings' => [
      'source_module' => 'content',
      'destination_module' => 'field',
    ],
    'd6_field_instance' => [
      'source_module' => 'content',
      'destination_module' => 'field',
    ],
    'd6_field_instance_widget_settings' => [
      'source_module' => 'content',
      'destination_module' => 'field',
    ],
    'd7_field' => [
      'source_module' => 'field',
      'destination_module' => 'field',
    ],
    'd7_field_formatter_settings' => [
      'source_module' => 'field',
      'destination_module' => 'field',
    ],
    'd7_field_instance' => [
      'source_module' => 'field',
      'destination_module' => 'field',
    ],
    'd7_field_instance_widget_settings' => [
      'source_module' => 'field',
      'destination_module' => 'field',
    ],
    'd7_view_modes' => [
      'source_module' => 'field',
      'destination_module' => 'field',
    ],
    'd6_file' => [
      'source_module' => 'system',
      'destination_module' => 'file',
    ],
    'd6_file_settings' => [
      'source_module' => 'system',
      'destination_module' => 'file',
    ],
    'd6_upload' => [
      'source_module' => 'upload',
      'destination_module' => 'file',
    ],
    'd6_upload_entity_display' => [
      'source_module' => 'upload',
      'destination_module' => 'file',
    ],
    'd6_upload_entity_form_display' => [
      'source_module' => 'upload',
      'destination_module' => 'file',
    ],
    'd6_upload_field' => [
      'source_module' => 'upload',
      'destination_module' => 'file',
    ],
    'd6_upload_field_instance' => [
      'source_module' => 'upload',
      'destination_module' => 'file',
    ],
    'd7_file' => [
      'source_module' => 'file',
      'destination_module' => 'file',
    ],
    'd6_filter_format' => [
      'source_module' => 'filter',
      'destination_module' => 'filter',
    ],
    'd7_filter_format' => [
      'source_module' => 'filter',
      'destination_module' => 'filter',
    ],
    'd6_forum_settings' => [
      'source_module' => 'forum',
      'destination_module' => 'forum',
    ],
    'd7_forum_settings' => [
      'source_module' => 'forum',
      'destination_module' => 'forum',
    ],
    'd6_imagecache_presets' => [
      'source_module' => 'imagecache',
      'destination_module' => 'image',
    ],
    'd7_image_settings' => [
      'source_module' => 'image',
      'destination_module' => 'image',
    ],
    'd7_image_styles' => [
      'source_module' => 'image',
      'destination_module' => 'image',
    ],
    'd7_language_negotiation_settings' => [
      'source_module' => 'locale',
      'destination_module' => 'language',
    ],
    'language' => [
      'source_module' => 'locale',
      'destination_module' => 'language',
    ],
    'locale_settings' => [
      'source_module' => 'locale',
      'destination_module' => 'locale',
    ],
    'd6_menu_links' => [
      'source_module' => 'menu',
      'destination_module' => 'menu_link_content',
    ],
    'd7_menu_links' => [
      'source_module' => 'menu',
      'destination_module' => 'menu_link_content',
    ],
    'menu_settings' => [
      'source_module' => 'menu',
      'destination_module' => 'menu_ui',
    ],
    'd6_node' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_node_revision' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_node_setting_promote' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_node_setting_status' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_node_setting_sticky' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_node_settings' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_node_type' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_view_modes' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd7_node' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd7_node_revision' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd7_node_settings' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd7_node_title_label' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd7_node_type' => [
      'source_module' => 'node',
      'destination_module' => 'node',
    ],
    'd6_url_alias' => [
      'source_module' => 'path',
      'destination_module' => 'path',
    ],
    'd7_url_alias' => [
      'source_module' => 'path',
      'destination_module' => 'path',
    ],
    'search_page' => [
      'source_module' => 'search',
      'destination_module' => 'search',
    ],
    'd6_search_settings' => [
      'source_module' => 'search',
      'destination_module' => 'search',
    ],
    'd7_search_settings' => [
      'source_module' => 'search',
      'destination_module' => 'search',
    ],
    'd7_shortcut' => [
      'source_module' => 'shortcut',
      'destination_module' => 'shortcut',
    ],
    'd7_shortcut_set' => [
      'source_module' => 'shortcut',
      'destination_module' => 'shortcut',
    ],
    'd7_shortcut_set_users' => [
      'source_module' => 'shortcut',
      'destination_module' => 'shortcut',
    ],
    'd6_simpletest_settings' => [
      'source_module' => 'simpletest',
      'destination_module' => 'simpletest',
    ],
    'd7_simpletest_settings' => [
      'source_module' => 'simpletest',
      'destination_module' => 'simpletest',
    ],
    'd6_statistics_settings' => [
      'source_module' => 'statistics',
      'destination_module' => 'statistics',
    ],
    'd6_syslog_settings' => [
      'source_module' => 'syslog',
      'destination_module' => 'syslog',
    ],
    'd7_syslog_settings' => [
      'source_module' => 'syslog',
      'destination_module' => 'syslog',
    ],
    'd6_date_formats' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_cron' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_date' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_file' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_image' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_image_gd' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_logging' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_maintenance' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_performance' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_rss' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'd6_system_site' => [
      'source_module' => 'system',
      'destination_module' => 'system',
    ],
    'menu' => [
      'source_module' => 'menu',
      'destination_module' => 'system',
    ],
    'taxonomy_settings' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_taxonomy_term' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_taxonomy_vocabulary' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_term_node' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_term_node_revision' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_vocabulary_entity_display' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_vocabulary_entity_form_display' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_vocabulary_field' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd6_vocabulary_field_instance' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd7_taxonomy_term' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'd7_taxonomy_vocabulary' => [
      'source_module' => 'taxonomy',
      'destination_module' => 'taxonomy',
    ],
    'text_settings' => [
      'source_module' => 'text',
      'destination_module' => 'text',
    ],
    'd7_tracker_node' => [
      'source_module' => 'tracker',
      'destination_module' => 'tracker',
    ],
    'd7_tracker_settings' => [
      'source_module' => 'tracker',
      'destination_module' => 'tracker',
    ],
    'd7_tracker_user' => [
      'source_module' => 'tracker',
      'destination_module' => 'tracker',
    ],
    'update_settings' => [
      'source_module' => 'update',
      'destination_module' => 'update',
    ],
    'd6_profile_values' => [
      'source_module' => 'profile',
      'destination_module' => 'user',
    ],
    'd6_user' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd6_user_contact_settings' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd6_user_mail' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd6_user_picture_file' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd6_user_role' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd6_user_settings' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd7_user' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd7_user_flood' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd7_user_mail' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'd7_user_role' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'user_picture_entity_display' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'user_picture_entity_form_display' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'user_picture_field' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'user_picture_field_instance' => [
      'source_module' => 'user',
      'destination_module' => 'user',
    ],
    'user_profile_entity_display' => [
      'source_module' => 'profile',
      'destination_module' => 'user',
    ],
    'user_profile_entity_form_display' => [
      'source_module' => 'profile',
      'destination_module' => 'user',
    ],
    'user_profile_field' => [
      'source_module' => 'profile',
      'destination_module' => 'user',
    ],
    'user_profile_field_instance' => [
      'source_module' => 'profile',
      'destination_module' => 'user',
    ],
  ];

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'migrate_upgrade_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $step = $form_state->getValue('step', 'overview');
    switch ($step) {
      case 'overview':
        return $this->buildOverviewForm($form, $form_state);
      case 'credentials':
        return $this->buildCredentialForm($form, $form_state);
      case 'confirm':
        return $this->buildConfirmForm($form, $form_state);
      default:
        drupal_set_message($this->t('Unrecognized form step @step',
          ['@step' => $step]), 'error');
        return [];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * Build the form presenting an overview of the migration process.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildOverviewForm(array $form, FormStateInterface $form_state) {
    $form['#title'] = $this->t('Drupal Upgrade');

    if ($date_performed = \Drupal::state()->get('migrate_upgrade.performed')) {
      $form['upgrade_option_item'] = [
        '#type' => 'item',
        '#prefix' => t('<p>An upgrade has already been performed on this site.</p>'),
        '#description' => t('<p>Last upgrade: @date</p>',
          ['@date' => \Drupal::service('date.formatter')->format($date_performed)]),
      ];
      $form['upgrade_option'] = array(
        '#type' => 'radios',
        '#title' => $this->t('You have two options:'),
        '#default_value' => static::MIGRATE_UPGRADE_INCREMENTAL,
        '#options' => [
          static::MIGRATE_UPGRADE_INCREMENTAL => $this->t('<strong>Rerun</strong>: Import additional configuration and content that was not available when running the upgrade previously.'),
          static::MIGRATE_UPGRADE_ROLLBACK => $this->t('<strong>Rollback</strong>: Remove content and configuration entities (such as fields and node types). Default values of other configuration will not be reverted (such as site name).'),
        ],
      );
      $validate = ['::validateCredentialForm'];
    }
    else {
      $form['info_header'] = [
        '#markup' => '<p>' . $this->t('Upgrade a Drupal site by importing it into a clean and empty new install of Drupal 8. You will lose any existing configuration once you import your site into it. See the <a href=":url">upgrading handbook</a> for more detailed information.', [
            ':url' => 'https://www.drupal.org/upgrade/migrate'
          ]),
      ];

      $info[] = $this->t('<strong>Back up the database for this site</strong>. Upgrade will change the database for this site.');
      $info[] = $this->t('Make sure that the host this site is on has access to the database for your previous site.');
      $info[] = $this->t('If your previous site has private files to be migrated, a copy of your files directory must be accessible on the host this site is on.');
      $info[] = $this->t('In general, enable all modules on this site that are enabled on the previous site. For example, if you have used the book module on the previous site then you must enable the book module on this site for that data to be available on this site.');
      $info[] = $this->t('Put this site into <a href=":url">maintenance mode</a>.', [
                  ':url' => Url::fromRoute('system.site_maintenance_mode')
                  ->toString(TRUE)
                  ->getGeneratedUrl(),
                ]);

      $form['info'] = [
        '#theme' => 'item_list',
        '#list_type' => 'ol',
        '#items' => $info,
      ];

      $form['info_footer'] = [
        '#markup' => '<p>' . $this->t('This upgrade can take a long time. It is better to import a local copy of your site instead of directly importing from your live site.'),
      ];

      $validate = [];
    }

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['save'] = [
      '#type' => 'submit',
      '#value' => $this->t('Continue'),
      '#button_type' => 'primary',
      '#validate' => $validate,
      '#submit' => ['::submitOverviewForm'],
    ];
    return $form;
  }

  /**
   * Overview form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitOverviewForm(array &$form, FormStateInterface $form_state) {
    switch ($form_state->getValue('upgrade_option')) {
      case static::MIGRATE_UPGRADE_INCREMENTAL:
        $form_state->setValue('step', 'confirm');
        break;
      case static::MIGRATE_UPGRADE_ROLLBACK:
        $form_state->setValue('step', 'confirm');
        break;
      default:
        $form_state->setValue('step', 'credentials');
        break;
    }
    $form_state->setRebuild();
  }

  /**
   * Build the form gathering database credential and file location information.
   * This is largely borrowed from SiteSettingsForm.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildCredentialForm(array $form, FormStateInterface $form_state) {
    // Make sure the install API is available.
    include_once DRUPAL_ROOT . '/core/includes/install.inc';

    $form['#title'] = $this->t('Drupal Upgrade');

    $drivers = drupal_get_database_types();
    $drivers_keys = array_keys($drivers);
    $default_driver = current($drivers_keys);
    $default_options = [];

    $form['database'] = [
      '#type' => 'details',
      '#title' => $this->t('Source database'),
      '#description' => $this->t('Provide credentials for the database of the Drupal site you want to upgrade.'),
      '#open' => TRUE,
    ];

    $form['database']['driver'] = [
      '#type' => 'radios',
      '#title' => $this->t('Database type'),
      '#required' => TRUE,
      '#default_value' => $default_driver,
    ];
    if (count($drivers) == 1) {
      $form['database']['driver']['#disabled'] = TRUE;
    }

    // Add driver specific configuration options.
    foreach ($drivers as $key => $driver) {
      $form['database']['driver']['#options'][$key] = $driver->name();

      $form['database']['settings'][$key] = $driver->getFormOptions($default_options);
      $form['database']['settings'][$key]['#prefix'] = '<h2 class="js-hide">' . $this->t('@driver_name settings', ['@driver_name' => $driver->name()]) . '</h2>';
      $form['database']['settings'][$key]['#type'] = 'container';
      $form['database']['settings'][$key]['#tree'] = TRUE;
      $form['database']['settings'][$key]['advanced_options']['#parents'] = [$key];
      $form['database']['settings'][$key]['#states'] = [
        'visible' => [
          ':input[name=driver]' => ['value' => $key],
        ]
      ];

      // Move the host fields out of advanced settings.
      if (isset ($form['database']['settings'][$key]['advanced_options']['host'])) {
        $form['database']['settings'][$key]['host'] = $form['database']['settings'][$key]['advanced_options']['host'];
        $form['database']['settings'][$key]['host']['#title'] = 'Database host';
        $form['database']['settings'][$key]['host']['#weight'] = -1;
        unset($form['database']['settings'][$key]['database']['#default_value']);
        unset($form['database']['settings'][$key]['advanced_options']['host']);
      }
    }

    $form['source'] = [
      '#type' => 'details',
      '#title' => $this->t('Source files'),
      '#open' => TRUE,
    ];
    $form['source']['source_base_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Files directory'),
      '#description' => $this->t('To import files from your current Drupal site, enter a local file directory containing your site (e.g. /var/www/docroot), or your site address (e.g. http://example.com).'),
    ];

    /*
      // @todo: Not yet implemented, depends on https://www.drupal.org/node/2547125.
      $form['files']['private_file_directory'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Private file path'),
        '#description' => $this->t('To import private files from your current Drupal site, enter a local file directory containing your files (e.g. /var/private_files).'),
      ];
    */

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['save'] = [
      '#type' => 'submit',
      '#value' => $this->t('Review upgrade'),
      '#button_type' => 'primary',
      '#limit_validation_errors' => [
        ['driver'],
        [$default_driver],
      ],
      '#validate' => ['::validateCredentialForm'],
      '#submit' => ['::submitCredentialForm'],
    ];
    return $form;
  }

  /**
   * Credential form validation handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateCredentialForm(array &$form, FormStateInterface $form_state) {
    // Skip if rollback was chosen.
    if ($form_state->getValue('upgrade_option') == static::MIGRATE_UPGRADE_ROLLBACK) {
      return;
    }

    // Retrieve the database driver from the form, use reflection to get the
    // namespace and then construct a valid database array the same as in
    // settings.php.
    if ($driver = $form_state->getValue('driver')) {
      $drivers = $this->getDatabaseTypes();
      $reflection = new \ReflectionClass($drivers[$driver]);
      $install_namespace = $reflection->getNamespaceName();

      $database = $form_state->getValue($driver);
      // Cut the trailing \Install from namespace.
      $database['namespace'] = substr($install_namespace, 0, strrpos($install_namespace, '\\'));
      $database['driver'] = $driver;

      // Validate the driver settings and just end here if we have any issues.
      if ($errors = $drivers[$driver]->validateDatabaseSettings($database)) {
        foreach ($errors as $name => $message) {
          $form_state->setErrorByName($name, $message);
        }
        return;
      }
    }
    else {
      // Find a migration which has database credentials and use those.
      $query = \Drupal::entityQuery('migration', 'OR');
      $ids = $query->execute();
      foreach ($ids as $id) {
        /** @var MigrationInterface $migration */
        $migration = Migration::load($id);
        $is_drupal_migration = FALSE;
        foreach ($migration->get('migration_tags') as $migration_tag) {
          if (substr($migration_tag, 0, 7) == 'Drupal ') {
            $is_drupal_migration = TRUE;
            break;
          }
        }
        if ($is_drupal_migration) {
          $source = $migration->get('source');
          if ($database = \Drupal::state()->get($source['database_state_key'])['database']) {
            break;
          }
        }
      }
    }

    try {
      // Create all the relevant migrations and get their IDs so we can run them.
      $migration_ids = $this->createMigrations($database, $form_state->getValue('source_base_path'));

      // Store the retrieved migration ids in form storage.
      $form_state->set('migration_ids', $migration_ids);
    }
    catch (\Exception $e) {
      $error_message = [
        '#type' => 'inline_template',
        '#template' => '{% trans %}Resolve the issue below to continue the upgrade.{% endtrans%}{{ errors }}',
        '#context' => [
          'errors' => [
            '#theme' => 'item_list',
            '#items' => [$e->getMessage()],
          ],
        ],
      ];

      $form_state->setErrorByName($database['driver'] . '][0', \Drupal::service('renderer')->renderPlain($error_message));
    }
  }

  /**
   * Credential form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitCredentialForm(array &$form, FormStateInterface $form_state) {
    // Indicate the next step is confirmation.
    $form_state->setValue('step', 'confirm');
    $form_state->setRebuild();
  }

  /**
   * Build the form gathering database credential and file location information.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildConfirmForm(array $form, FormStateInterface $form_state) {
    $rollback = $form_state->getValue('upgrade_option') == static::MIGRATE_UPGRADE_ROLLBACK;
    if ($rollback) {
      $form_state->setStorage(['upgrade_option' => static::MIGRATE_UPGRADE_ROLLBACK]);
    }
    $form['#title'] = $this->getQuestion();

    $form['#attributes']['class'][] = 'confirmation';
    $form[$this->getFormName()] = ['#type' => 'hidden', '#value' => 1];

    if ($rollback) {
      $form['rollback'] = [
        '#markup' => $this->t('All previously-imported content, as well as configuration such as field definitions, will be removed.'),
      ];
    }
    else {
      $table_data = [];
      $system_data = [];
      foreach ($form_state->get('migration_ids') as $migration_id) {
        /** @var MigrationInterface $migration */
        $migration = Migration::load($migration_id);
        // Fetch the system data at the first opportunity.
        if (empty($system_data) && is_a($migration->getSourcePlugin(), '\Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase')) {
          $system_data = $migration->getSourcePlugin()->getSystemData();
        }
        $template_id = $migration->get('template');
        $source_module = $this->moduleUpgradePaths[$template_id]['source_module'];
        $destination_module = $this->moduleUpgradePaths[$template_id]['destination_module'];
        $table_data[$source_module][$destination_module][$migration_id] = $migration->label();
      }
      ksort($table_data);
      foreach ($table_data as $source_module => $destination_module_info) {
        ksort($table_data[$source_module]);
      }
      $unmigrated_source_modules = array_diff_key($system_data['module'], $table_data);

      // Missing migrations.
      $desc = "The following items will not be upgraded. " .
        'For more information see <a href="https://www.drupal.org/upgrade/migrate"> Upgrading from Drupal 6 or 7 to Drupal 8</a>.';
      $form['missing_module_list_title'] = [
        '#type' => 'item',
        '#title' => t('Missing upgrade paths'),
        '#description' => $this->t($desc),
      ];
      $form['missing_module_list'] = [
        '#type' => 'table',
        '#header' => [
          $this->t('Source'),
          $this->t('Destination'),
        ],
      ];
      $missing_count = 0;
      ksort($unmigrated_source_modules);
      foreach ($unmigrated_source_modules as $source_module => $module_data) {
        if ($module_data['status']) {
          $missing_count++;
          $form['missing_module_list'][$source_module] = [
            'source_module' => ['#plain_text' => $source_module],
            'destination_module' => ['#plain_text' => 'Missing'],
          ];
        }
      }
      // Available migrations.
      $form['available_module_list'] = [
        '#tree' => TRUE,
        '#type' => 'details',
        '#title' => t('Available upgrade paths'),
      ];

      $form['available_module_list']['module_list'] = [
        '#type' => 'table',
        '#header' => [
          $this->t('Source'),
          $this->t('Destination'),
        ],
      ];

      $available_count = 0;
      foreach ($table_data as $source_module => $destination_module_info) {
        $available_count++;
        $destination_details = [];
        foreach ($destination_module_info as $destination_module => $migration_ids) {
          $destination_details[$destination_module] = [
            '#type' => 'item',
            '#plain_text' => t($destination_module),
          ];
        }
        $form['available_module_list']['module_list'][$source_module] = [
          'source_module' => ['#plain_text' => $source_module],
          'destination_module' => $destination_details,
        ];
      }
      $form['counts'] = [
        '#type' => 'item',
        '#title' => "<ul><li>" . t($available_count . ' available upgrade paths') .
        "</li><li>" . t($missing_count . ' missing upgrade paths') . "</li></ul>",
        '#weight' => -15,
      ];
    }
    if ($rollback) {
      $confirm_text = $this->t('Perform rollback');
    }
    else {
      $confirm_text = $this->t('Perform upgrade');
    }
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $confirm_text,
      '#button_type' => 'primary',
      '#validate' => [],
      '#submit' => ['::submitConfirmForm'],
    ];

    $form['actions']['cancel'] = ConfirmFormHelper::buildCancelLink($this, $this->getRequest());

    // By default, render the form using theme_confirm_form().
    if (!isset($form['#theme'])) {
      $form['#theme'] = 'confirm_form';
    }
    return $form;
  }

  /**
   * Credential form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitConfirmForm(array &$form, FormStateInterface $form_state) {
    $storage = $form_state->getStorage();
    if (isset($storage['upgrade_option']) && $storage['upgrade_option'] == static::MIGRATE_UPGRADE_ROLLBACK) {
      $query = \Drupal::entityQuery('migration');
      $names = $query->execute();

      // Order the migrations according to their dependencies.
      /** @var MigrationInterface[] $migrations */
      $migrations = \Drupal::entityManager()
         ->getStorage('migration')
         ->loadMultiple($names);
      // Assume we want all those tagged 'Drupal %'.
      foreach ($migrations as $migration_id => $migration) {
        $keep = FALSE;
        $tags = $migration->get('migration_tags');
        foreach ($tags as $tag) {
          if (strpos($tag, 'Drupal ') === 0) {
            $keep = TRUE;
            break;
          }
        }
        if (!$keep) {
          unset($migrations[$migration_id]);
        }
      }
      // Roll back in reverse order.
      $migrations = array_reverse($migrations);

      $batch = [
        'title' => $this->t('Rolling back upgrade'),
        'progress_message' => '',
        'operations' => [
          [
            ['Drupal\migrate_upgrade\MigrateUpgradeRunBatch', 'run'],
            [array_keys($migrations), 'rollback']
          ],
        ],
        'finished' => [
          'Drupal\migrate_upgrade\MigrateUpgradeRunBatch',
          'finished'
        ],
      ];
      batch_set($batch);
      $form_state->setRedirect('migrate_upgrade.upgrade');
      \Drupal::state()->delete('migrate_upgrade.performed');
    }
    else {
      $batch = [
        'title' => $this->t('Running upgrade'),
        'progress_message' => '',
        'operations' => [
          [
            ['Drupal\migrate_upgrade\MigrateUpgradeRunBatch', 'run'],
            [$form_state->get('migration_ids'), 'import']
          ],
        ],
        'finished' => [
          'Drupal\migrate_upgrade\MigrateUpgradeRunBatch',
          'finished'
        ],
      ];
      batch_set($batch);
      $form_state->setRedirect('<front>');
      \Drupal::state()->set('migrate_upgrade.performed', REQUEST_TIME);
    }
  }

  /**
   * Returns all supported database driver installer objects.
   *
   * @return \Drupal\Core\Database\Install\Tasks[]
   *   An array of available database driver installer objects.
   */
  protected function getDatabaseTypes() {
    // Make sure the install API is available.
    include_once DRUPAL_ROOT . '/core/includes/install.inc';
    return drupal_get_database_types();
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('migrate_upgrade.upgrade');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('<p><strong>Upgrade analysis report</strong></p>');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Perform upgrade');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return $this->t('Cancel');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormName() {
    return 'confirm';
  }

}
