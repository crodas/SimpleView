<?php
use crodas\SimpleView\Environment;
use crodas\SimpleView\Runtime;

require __DIR__ . "/../vendor/autoload.php";

@unlink(__DIR__  . '/Templates.php');
@unlink(__DIR__  . '/Templates.php.lock');

Asset::addPath(__DIR__);

$env = new Environment(__DIR__ . '/views');
$run = new Runtime(__DIR__ . '/Templates.php', $env);
$run->setNamespace('Tests')
    ->development()
    ->load();

