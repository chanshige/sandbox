<?php

use Pimple\Container;

$container = new Container();
// debug
$container['debug'] = (bool)getenv('DEBUG_MODE');

$container['dateTime'] = function () {
    return new DateTimeImmutable();
};
$container['guzzle'] = function () {
    return new \GuzzleHttp\Client();
};
// handler
$container['backlog.handler'] = function () use ($container) {
    return new \Jobchan\Handler\BacklogHandler($container['guzzle'], getenv('BACKLOG_SPACE_URL'));
};
$container['slack.handler'] = function () use ($container) {
    return new \Jobchan\Handler\SlackHandler($container['guzzle'], getenv('SLACK_WEBHOOK_URL'));
};
// command
$container['command.hello'] = function () {
    return new \Jobchan\Command\HelloCommand();
};
$container['command.estimate'] = function () use ($container) {
    return new \Jobchan\Command\Notice\EstimateMitsuru(
        $container['backlog.handler'],
        $container['slack.handler'],
        $container['dateTime']
    );
};
$container['command.credit'] = function () use ($container) {
    return new \Jobchan\Command\Notice\HiroshiCredit(
        $container['backlog.handler'],
        $container['slack.handler']
    );
};
$container['command.resource'] = function () use ($container) {
    return new \Jobchan\Command\Notice\ResourceBooya(
        $container['backlog.handler'],
        $container['slack.handler']
    );
};
// add
$application->addCommands(
    array(
        $container['command.hello'],
        $container['command.estimate'],
        $container['command.credit'],
        $container['command.resource'],
    )
);
