<?php
namespace Selenium;

use Symfony\Component\Console\Application;

/**
 * Class Base (師匠ベースクラス)
 *
 * @package Selenium
 */
class Base
{
    private $app;

    /**
     * Base constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        require_once BASE_DIR . 'config/settings.php';
        $this->app = $application;
    }

    /**
     * Return Console Object.
     *
     * @return Application
     */
    public function get()
    {
        return $this->app;
    }
}
