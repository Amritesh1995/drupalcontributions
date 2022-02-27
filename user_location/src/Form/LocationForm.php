<?php
/**
 * @file
 * Contains Drupal\user_location\Form\LocationForm.
 */  
namespace Drupal\user_location\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
  
class LocationForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'location.adminsettings',
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('location.adminsettings');
    $timezone_list = [];
    $timezone_list['America/Chicago'] = "America/Chicago";
    $timezone_list['America/New_York'] = "America/New_York";
    $timezone_list['Asia/Tokyo'] = "Asia/Tokyo";
    $timezone_list['Asia/Dubai'] = "Asia/Dubai";
    $timezone_list['Asia/Kolkata'] = "Asia/Kolkata";
    $timezone_list['Europe/Amsterdam'] = "Europe/Amsterdam";
    $timezone_list['Europe/Oslo'] = "Europe/Oslo";
    $timezone_list['Europe/London'] = "Europe/London";
    $form['country_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#description' => $this->t('Please enter country name'),
      '#default_value' => $config->get('country_name'),
    ];
    $form['city_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description' => $this->t('Please enter city name'),
      '#default_value' => $config->get('city_name'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#description' => $this->t('Please enter timezone'),
      '#options' => $timezone_list,
      '#default_value' => $config->get('timezone'),
    ];


    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('location.adminsettings')
      ->set('country_name', $form_state->getValue('country_name'))
      ->set('city_name', $form_state->getValue('city_name'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
  }
}