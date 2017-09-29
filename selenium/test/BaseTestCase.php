<?php
namespace Test;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends TestCase
{
    protected $expected;
    protected $actual;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    protected function verify($message = '')
    {
        $this->assertEquals($this->expected, $this->actual, $message);
    }

    /**
     * Get WebDriver.
     *
     * @param DesiredCapabilities|array $desiredCapabilities
     * @return RemoteWebDriver
     */
    protected function webDriver($desiredCapabilities)
    {
        return RemoteWebDriver::create(
            'http://localhost:4444/wd/hub',
            $desiredCapabilities
        );
    }
}
