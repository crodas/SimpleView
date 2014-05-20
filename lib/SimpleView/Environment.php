<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2014 César Rodas                                                  |
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

/**
 *  based on Laravel4's view engine Blade.
 *
 *  http://laravel.com - https://github.com/illuminate/view
 */
namespace crodas\SimpleView;

use Symfony\Component\Finder\Finder;

class Environment
{
    protected $finder;
    protected $obj = array();
    protected $macros = array();

    public function set($name, $value)
    {
        $this->obj[$name] = $value;
        return $this;
    }

    public function get($name)
    {
        if (!array_key_exists($name, $this->obj)) {
            throw new \RuntimeException("Cannot find property {$name}");
        }
        return $this->obj[$name];
    }

    public function __construct($dir, $ext = null)
    {
        if ($dir instanceof Finder) {
            $finder = $dir;
        } else { 
            $finder = new Finder;
            foreach ((array)$dir as $_dir) {
                if (!is_dir($_dir)) {
                    throw new \RuntimeException("{$_dir} is not a directory");
                }
                $finder->in($_dir);
            }

            $finder->files()->in($dir);
            if (empty($ext)) {
                $ext = array('.tpl.php', '.tpl', '.html');
            }
            foreach ((Array)$ext as $e) {
                $finder->name("*{$e}");
            }
        }
        $this->finder = $finder;
    }

    public function getMacros()
    {
        return array_map(function($obj) {
            return $obj::getType();
        }, $this->getMacrosObjects());
    }

    public function getMacrosObjects()
    {
        $macros = [];
        foreach ($this->macros as $macro) {
            foreach ($macro::getNames() as $name) {
                $macros[$name] = $macro;
            }
        }

        return $macros;
    }

    public function addMacro($macro)
    {
        $this->macros[] = $macro;
        return $this;
    }

    public function files()
    {
        return $this->finder->files();
    }
}
