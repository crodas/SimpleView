<?php
use crodas\SimpleView\Environment;
use crodas\SimpleView\Compiler;

require __DIR__ . "/../vendor/autoload.php";

$compiler = new Compiler(new Environment(__DIR__ . '/views'));
$compiler->setNamespace('Tests');
$compiler->compile();
$compiler->save(__DIR__ . '/Templates.php');

require __DIR__ . '/Templates.php';
