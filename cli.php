<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2013 César Rodas                                                  |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/

require "vendor/autoload.php";

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use crodas\SimpleView\Environment;
use crodas\SimpleView\Compiler;
use Symfony\Component\Finder\Finder;

$console = new Application();
$console
    ->register('compile')
    ->setDescription('Compile all templates and save them in a single file')
    ->setDefinition([
        new InputArgument('dir',    InputArgument::OPTIONAL, 'Directory to compile'),
        new InputArgument('output', InputArgument::OPTIONAL, 'Directory to compile'),
    ])
    ->addOption(
        'namespace',
        'N',
        InputOption::VALUE_REQUIRED,
        ''
    )
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $dir  = $input->getArgument('dir') ?: getcwd();
        $file = $input->getArgument('output') ?: $dir . '/Templates.php'; 

        $compiler = new Compiler(new Environment($dir));
        $compiler->setNamespace($input->getOption('namespace'));
        $compiler->compile();


        $output->writeln(sprintf('Created <info>%s</info>', $file));
        file_put_contents($file, $compiler->getCode());
    });

$console
    ->register('phar')
    ->setDescription('Creates a phar file')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $finder = new Finder();
        $finder->files()->name("*.php")
            ->in(__DIR__)
            ->filter(function($x) {
                return preg_match("/^(lib|vendor)/", $x->getRelativePath());
            });

        $phar = new Phar('view-compiler.phar');
        foreach ($finder as $file) {
            $phar->addFile($file, $file->getRelativePathname());
        }
        $phar->addFile('cli.php');
        $phar->setStub("#!" . PHP_BINARY . "\n"
            . $phar->createDefaultStub("cli.php")
        );
    });

$console->run();
