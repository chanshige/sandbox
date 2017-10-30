<?php
namespace Selenium\Driver;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Class Chrome (Google Chrome Driver.)
 *
 * @package Selenium\Driver
 */
class Chrome implements DriverInterface
{
    /**
     * @return RemoteWebDriver
     */
    public static function create()
    {
        return RemoteWebDriver::create(
            'http://localhost:4444/wd/hub',
            Chrome::capabilities(),
            5000
        );
    }

    /**
     * @return DesiredCapabilities
     */
    public static function capabilities()
    {
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(
            ChromeOptions::CAPABILITY,
            (new ChromeOptions())->addArguments(['--headless'])
        );

        return $capabilities;
    }
}
