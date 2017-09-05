<?php
namespace Jobchan;

use Symfony\Component\Console\Application;

/**
 * Class App
 *
 * @package Jobchan
 */
class App
{
    /** @var Application */
    private $application;

    /**
     * App constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        require APP_DIR . "src/Resource/dependency.php";
        $this->application = $application;
    }

    /**
     * @return Application
     */
    public function get()
    {
        return $this->application;
    }
}
