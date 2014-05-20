<?php
use crodas\SimpleView\Environment;
use crodas\SimpleView\Runtime;

require __DIR__ . "/../vendor/autoload.php";

Asset::prod();
Asset::on('output', function($ev) {
    $args = $ev->getArguments();
    $args[0] = "//foobar.com/assets/" . $args[0];
});

@unlink(__DIR__  . '/Templates.php');
@unlink(__DIR__  . '/Templates.php.lock');

Asset::addPath(__DIR__);

$env = new Environment(__DIR__ . '/views');
$run = new Runtime(__DIR__ . '/Templates.php', $env);
$run->setNamespace('Tests')
    ->development()
    ->load();

