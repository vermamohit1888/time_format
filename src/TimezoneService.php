<?php

namespace Drupal\time_format;

use Drupal\Core\Config\ConfigFactory;

/**
 * Class TimezoneService.
 */
class TimezoneService {


   /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructs a new TimezoneService object.
   */

  public function __construct(ConfigFactory $configfactory) {
    $this->configFactory = $configfactory;

  }

  /**
   * Gets time format.
   */
   public function gettimeformat() {
    $config = $this->configFactory->get('time_format.timeformat');
    $newtz = new \DateTimeZone($config->get('timezone'));
    $date = new \DateTime(date('Y-m-d H:i:s'));
    $date->setTimezone($newtz);
    $timeformat = $date->format('dS M Y - h:i A');
    return $timeformat;
  }


}
