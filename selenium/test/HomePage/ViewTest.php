<?php
namespace Test\HomePage;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Test\BaseTestCase;

/**
 * Class ViewTest
 *
 * @package Test\HomePage
 */
class ViewTest extends BaseTestCase
{
    /** @var RemoteWebDriver */
    protected $driver;

    protected function setUp()
    {
        $this->driver = $this->webDriver(DesiredCapabilities::chrome());
        $this->driver->get('https://shigeki.jp');
    }

    protected function tearDown()
    {
        $this->driver->quit();
    }

    public function testSiteTitle()
    {
        $this->assertEquals('Shigeki Tanaka Website', $this->driver->getTitle());
    }

    public function testContactPageTitle()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.bottom-zero a')
        )->click();

        $this->assertEquals('CONTACT | Shigeki Tanaka Website', $this->driver->getTitle());
    }
}
