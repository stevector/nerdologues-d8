/**
 * @file
 * Timezone detection.
 */

(function ($) {

  'use strict';

  /**
   * Set the client's system time zone as default values of form fields.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.nerdThemeMenu = {
    attach: function (context, settings) {

      $(".show-menu-button").click(function() {
        $( ".main-nav" ).addClass('show-menu');
      });
      $(".hide-menu-button").click(function() {
        $( ".main-nav" ).removeClass('show-menu');
      });


    }
  };

})(jQuery);
