<?php

namespace Drupal\youtube\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Youtube settings for this site.
 */
class YoutubeSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'youtube_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['youtube.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory->get('youtube.settings');
    $form['text'] = [
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('The following settings will be used as
        default values on all YouTube video fields.  Many of these settings can
        be overridden on a per-field basis.') . '</p>',
    ];
    $form['youtube_global'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Video parameters'),
    ];
    $form['youtube_global']['youtube_suggest'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show suggested videos when the video finishes'),
      '#default_value' => $config->get('youtube_suggest'),
    ];
    $form['youtube_global']['youtube_modestbranding'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Do not show YouTube logo on video player control bar
        (modestbranding).'),
      '#default_value' => $config->get('youtube_modestbranding'),
    ];
    $form['youtube_global']['youtube_theme'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use a light colored control bar for video player
        controls (theme).'),
      '#default_value' => $config->get('youtube_theme'),
    ];
    $form['youtube_global']['youtube_color'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use a white colored video progress bar (color).'),
      '#default_value' => $config->get('youtube_color'),
      '#description' => $this->t('Note: the modestbranding parameter will be
        ignored when this is in use.'),
    ];
    $form['youtube_global']['youtube_enablejsapi'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable use of the IFrame API (enablejsapi, origin).'),
      '#default_value' => $config->get('youtube_enablejsapi'),
      '#description' => $this->t('For more information on the IFrame API and how
        to use it, see the
        <a href="@api_reference">IFrame API documentation</a>.',
        ['@api_reference' => 'https://developers.google.com/youtube/iframe_api_reference']
      ),
    ];
    $form['youtube_global']['youtube_wmode'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Fix overlay problem on IE8 and lower'),
      '#default_value' => $config->get('youtube_wmode'),
      '#description' => $this->t('Checking this will fix the issue of a YouTube
        video showing above a modal window (including Drupal\'s Overlay). This
        is needed if you have Overlay users in IE or have modal windows
        throughout your site.'),
    ];
    $form['youtube_global']['youtube_override'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow users to override parameters.'),
      '#default_value' => $config->get('youtube_override', FALSE),
      '#description' => $this->t('This will allow users to pass parameter values
        into the YouTube URL provided in the field input. For example, adding
        "&start=30" to the end of the URL would start the embedded video at the
        30 second mark. This may have unintended side effects if parameter
        values are ever passed by accident.'),
    ];
    $form['youtube_thumbs'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Thumbnails'),
    ];
    $form['youtube_thumbs']['youtube_thumb_dir'] = [
      '#type' => 'textfield',
      '#title' => $this->t('YouTube thumbnail directory'),
      '#field_prefix' => 'public://',
      '#field_suffix' => '/thumbnail.jpg',
      '#description' => $this->t('Location, within the files directory, where
        you would like the YouTube thumbnails stored.'),
      '#default_value' => $config->get('youtube_thumb_dir'),
    ];
    $fom['youtube_thumbs']['youtube_thumb_hires'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Save higher resolution thumbnail images'),
      '#description' => $this->t('This will save thumbnails larger than the
        default size, 480x360, to the thumbnails directory specified above.'),
      '#default_value' => $config->get('youtube_thumb_hires'),
    ];
    $form['youtube_thumbs']['youtube_thumb_token_image_style'] = [
      '#type' => 'select',
      '#options' => image_style_options(TRUE),
      '#title' => $this->t('Default token image style'),
      '#description' => $this->t('Default image style for the output of a
        youtube_image_url token.'),
      '#default_value' => $config->get('youtube_thumb_token_image_style'),
    ];
    $form['youtube_thumbs']['youtube_thumb_delete_all'] = [
      '#type' => 'submit',
      '#value' => $this->t('Refresh existing thumbnail image files'),
      '#submit' => ['youtube_thumb_delete_all'],
    ];
    $form['youtube_privacy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable privacy-enhanced mode'),
      '#default_value' => $config->get('youtube_privacy'),
      '#description' => $this->t('Checking this box will prevent YouTube from
        setting cookies in your site visitors browser.'),
    ];
    $form['youtube_player_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('YouTube player class'),
      '#default_value' => $config->get('youtube_player_class'),
      '#description' => $this->t('The iframe of every player will be given this
        class. They will also be given IDs based off of this value.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->configFactory->getEditable('youtube.settings')
      ->set('youtube_suggest', $values['youtube_suggest'])
      ->set('youtube_modestbranding', $values['youtube_modestbranding'])
      ->set('youtube_theme', $values['youtube_theme'])
      ->set('youtube_color', $values['youtube_color'])
      ->set('youtube_enablejsapi', $values['youtube_enablejsapi'])
      ->set('youtube_privacy', $values['youtube_privacy'])
      ->set('youtube_wmode', $values['youtube_wmode'])
      ->set('youtube_override', $values['youtube_override'])
      ->set('youtube_player_class', $values['youtube_player_class'])
      ->set('youtube_thumb_dir', $values['youtube_thumb_dir'])
      ->set('youtube_thumb_hires', $values['youtube_thumb_hires'])
      ->set('youtube_thumb_token_image_style', $values['youtube_thumb_token_image_style'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
