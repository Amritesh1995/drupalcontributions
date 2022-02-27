<?php

/**
* @file providing the service that returns date time as per timezone.
*
*/
namespace  Drupal\user_location\Service;

class GetTimeService {

  public function getModifiedTime() {
    $location_config = \Drupal::config('location.adminsettings');
    date_default_timezone_set($location_config->get('timezone'));
    return date('jS M Y - h:i A');
  }
}