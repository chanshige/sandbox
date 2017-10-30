<?php

$app->register(new \Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => APP_DIR . '/templates'
    )
);
