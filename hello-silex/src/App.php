<?php
namespace Hello;

use Silex\Application;

class App
{
    /**
     * @var \Silex\Application
     */
    private $app;

    /**
     * App constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $app['debug'] = true;

        require APP_DIR . 'config/dependency.php';
        require APP_DIR . "src/Resource/routes.php";

        $this->app = $app;
    }

    /**
     * Return Silex App.
     *
     * @return Application
     */
    public function get()
    {
        return $this->app;
    }
}
