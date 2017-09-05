<?php
date_default_timezone_set('Asia/Tokyo');
require __DIR__ . "/vendor/autoload.php";

use Jobchan\App;
use Symfony\Component\Console\Application;

const APP_DIR = __DIR__ . "/";

const APP_NAME = 'Jobchan';
const APP_VERSION = 'v0.0.1';

$dotenv = new \Dotenv\Dotenv(APP_DIR);
$dotenv->load();

$application = (new App(new Application(APP_NAME, APP_VERSION)))->get();
$application->run();
