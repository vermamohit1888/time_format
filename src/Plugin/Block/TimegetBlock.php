<?php

namespace Drupal\time_format\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\time_format\TimezoneService;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Cache\UncacheableDependencyTrait;



/**
 * Provides a 'TimegetBlock' block.
 *
 * @Block(
 *  id = "timeget_block",
 *  admin_label = @Translation("Timeget block"),
 * )
 */
class TimegetBlock extends BlockBase implements ContainerFactoryPluginInterface {
  use UncacheableDependencyTrait;

  /**
   * Drupal\time_format\TimezoneService definition.
   *
   * @var \Drupal\time_format\TimezoneService
   */
  protected $timeFormatTimezone;


  /**
  * @var \Drupal\Core\Config\ConfigFactoryInterface
  */
 protected $configFactory;

 public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory, TimezoneService $timeFormatTimezone) {
  parent::__construct($configuration, $plugin_id, $plugin_definition);
  $this->configFactory = $configFactory;
  $this->timeFormatTimezone = $timeFormatTimezone;

}




  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->get('config.factory'),
          $container->get('time_format.timezone')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    \Drupal::service('page_cache_kill_switch')->trigger();
    $build['#theme'] = 'timeget_block';
    $build['#data']['cdata'] = $this->gettime();
    $build['#data']['ldata'] = $this->getlocation();
    return $build;
  }


  public function gettime(){
    $gettime = $this->timeFormatTimezone->gettimeformat();
    return $gettime;
  }

  public function getlocation(){
    $config = $this->configFactory->getEditable('time_format.timeformat');
    $timezone = $config->get('timezone');
    $tz = new \DateTimeZone($timezone);
    $gl = $tz->getLocation();
    return $gl;
  }





}
