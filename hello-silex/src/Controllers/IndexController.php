<?php
namespace Hello\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function __invoke(Application $app, Request $request)
    {
        return $app['twig']->render('index.twig', array('message' => 'Hello Silex'));
    }
}
