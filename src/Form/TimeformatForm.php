<?php

namespace Drupal\time_format\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TimeformatForm.
 */
class TimeformatForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'time_format.timeformat',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'timeformat_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('time_format.timeformat');
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#maxlength' => 255,
      '#size' => 64,
      '#required' => true,
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#maxlength' => 255,
      '#required' => true,
      '#size' => 64,
      '#default_value' => $config->get('city'),
    ];

    $arrt = ['' => '---Select Time zone---',
             'America/Chicago' => 'America/Chicago',
             'America/New_York' => 'America/New_York',
             'Asia/Tokyo'  => 'Asia/Tokyo',
             'Asia/Dubai' => 'Asia/Dubai',
             'Asia/Kolkata' => 'Asia/Kolkata',
             'Europe/Amsterdam' => 'Europe/Amsterdam',
             'Europe/Oslo' => 'Europe/Oslo',
             'Europe/London' => 'Europe/London'

    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#options' => $arrt,
      '#required' => true,
      '#title' => $this->t('Timezone'),
      '#default_value' => $config->get('timezone'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('time_format.timeformat')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
  }

}
