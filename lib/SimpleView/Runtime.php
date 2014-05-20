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
namespace crodas\SimpleView;

use WatchFiles\Watch;
use ServiceProvider\EventEmitter;

class Runtime
{
    use EventEmitter;

    protected $tmp;
    protected $ns;
    protected $loaded;
    protected $devel;

    public function __construct($tpl, $env)
    {
        $this->tmp = $tpl;
        $this->env = $env;
    }

    public function development()
    {
        $this->devel = true;
        return $this;
    }

    public function setNamespace($ns)
    {
        $this->ns = $ns;
        return $this;
    }

    public function load()
    {
        if ($this->loaded) return $this->ns . "\\Templates";
        if ($this->devel || !is_file($this->tmp)) {
            $watcher = new Watch($this->tmp . ".lock");
            if (!$watcher->isWatching() || $watcher->hasChanged()) {
                $compiler = new Compiler($this->env);
                $this->env->set('watcher', $watcher);
                if ($this->ns) {
                    $compiler->setNamespace($this->ns);
                }
                self::trigger('preCompile');
                foreach ($compiler->compile() as $compiled) {
                    $watcher->watchFile($compiled.'');
                    $watcher->watchDir(dirname($compiled));
                }
                self::trigger('ppostCompile');
                $compiler->save($this->tmp);
                $watcher->watchFile($this->tmp);
                $watcher->watch();
            }
        }

        require $this->tmp;
        $this->loaded = true;

        return $this->ns . "\\Templates";
    }

    public function get($name, $args)
    {
        $class = $this->load();
        return $class::get($name, $args);
    }
}
