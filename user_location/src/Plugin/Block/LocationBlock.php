<?php

/**
 * @file
 * Contains \Drupal\user_location\Plugin\Block\LocationBlock
 */

namespace Drupal\user_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\user_location\Service\GetTimeService;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'Location' block.
 * 
 * @Block(
 *   id = "location_block",
 *   admin_label = @Translation("Location Block"),
 *   category = @Translation("Location Block"),
 * )
 */

class LocationBlock extends BlockBase implements ContainerFactoryPluginInterface {
  // Custom Timezone
  protected $tzone = NULL;
  
  /*
   * Static create function provided by the ContainerFactoryPluginInterface.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('user_location.get_time')
    );
  }

  /*
   * BlockBase plugin constructor that's expecting the Timezone object provided by create().
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, GetTimeService $tzone) {
    // Instantiate the BlockBase parent
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    // Save the timezone passed to this constructor via dependency injection
    $this->tzone = $tzone;
  }

  /*
   * Return the render array.
   */
  public function build() {
    $location_config = \Drupal::config('location.adminsettings');
    return [
      '#theme' => 'location_block_display',
      '#country' => $location_config->get('country_name'),
      '#city' => $location_config->get('city_name'),
      '#date_time' => $this->tzone->getModifiedTime()
    ];
  }
}