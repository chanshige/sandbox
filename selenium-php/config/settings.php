<?php
/** SSL Check */
$application->add(new \Selenium\Command\SSLChecker(new Selenium\Driver\Chrome()));
