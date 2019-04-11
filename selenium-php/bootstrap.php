<?php

use Selenium\Base;
use Symfony\Component\Console\Application;

require_once __DIR__ . "/define.php";
require_once __DIR__ . "/vendor/autoload.php";

$application = (new Base(new Application(NAME, VERSION)))->get();
$application->run();
