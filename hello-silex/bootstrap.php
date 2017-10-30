<?php
require __DIR__ . '/vendor/autoload.php';

const APP_DIR = __DIR__ . "/";

$app = (new \Hello\App(new \Silex\Application()))->get();
$app->run();
