<?php
namespace Selenium\Driver;

use Facebook\WebDriver\Remote\DesiredCapabilities;

/**
 * Interface DriverInterface
 *
 * @package Selenium\Driver
 */
interface DriverInterface
{
    /**
     * Return create driver.
     *
     * @return mixed
     */
    public static function create();

    /**
     * @return DesiredCapabilities
     */
    public static function capabilities();
}
