(function ($, Drupal) {

  'use strict';

  /**
   * Provides the summaries for the vertical tabs in the CDN UI's settings form.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   */
  Drupal.behaviors.cdnSettingsSummary = {
    attach: function () {
      $('[data-drupal-selector="edit-status"]').drupalSetSummary(function () {
        return document.querySelector('input[name="status"]').checked ? Drupal.t('Enabled') : Drupal.t('Disabled');
      });

      $('[data-drupal-selector="edit-mapping"]').drupalSetSummary(function () {
        if (document.querySelector('select[name="mapping[type]"]').value === 'simple') {
          var domain = document.querySelector('input[name="mapping[simple][domain]"]').value;
          var which;
          switch (document.querySelector('select[name="mapping[simple][extensions_condition_toggle]"]').value) {
            case 'all':
              which = Drupal.t('all files');
              break;
            case 'nocssjs':
              which = Drupal.t('all files except CSS+JS');
              break;
            case 'limited':
              which = Drupal.t('some files');
              break;
          }
          return Drupal.t('!domain: !which', {'!which': which, '!domain': domain ? domain : Drupal.t('none configured yet')});
        }
        else {
          return Drupal.t('Advanced: <code>cdn.settings.yml</code>');
        }
      });

      $('[data-drupal-selector="edit-farfuture"]').drupalSetSummary(function () {
        return document.querySelector('input[name="farfuture[status]"]').checked ? Drupal.t('Enabled') : Drupal.t('Disabled');
      });
    }
  };

})(jQuery, Drupal);
