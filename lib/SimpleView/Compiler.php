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

use Symfony\Component\Finder\SplFileInfo;
use Simple_View_Parser as Parser;

require_once __DIR__ . "/Parser.php";

class Compiler
{
    protected $env;
    protected $compiled = array();
    protected $code;
    protected $ns;

    public function __construct($env)
    {
        $this->env = $env;
        $env->addMacro(__NAMESPACE__ .  '\Macro\Asset');
        $env->addMacro(__NAMESPACE__ .  '\Macro\AssetInline');
    }

    public function compile_string($name, $text)
    {
        $tokenizer = new Tokenizer($this->env);
        $parser    = new Parser($name);
        $tokens = $tokenizer->getTokens($text);
        foreach ($tokens as $token) {
            try {
                $parser->doParse($token[0], $token[1]);
            } catch (Exception $e) {
                $e->setLine($token[2]);
                throw $e;
            }
        }
        $template = new Template($parser->body, $this->env);
        $template->setSource($name);
        $this->compiled[$name] = $template;
        return $this;
    }

    protected function compile_file(SplFileInfo $file)
    {
        try {
            $this->compile_string($file->getRelativePathname(), file_get_contents($file));
        } catch (Exception $e) {
            $e->setFile((string)$file);
            throw $e;
        }
        return $this;
    }

    public function setNamespace($ns)
    {
        $this->ns = $ns;
        return $this;
    }

    public function getNamespace()
    {
        return $this->ns;
    }

    public function getCode()
    {
        $classes = array();
        $tpls    = array();
        $sections = array();
        foreach ($this->compiled as $name => $tpl) {
            $zname    = strtolower($name);
            $parts  = explode(".", $zname);
            $class  = 'class_' . sha1($name);
            $tpls[] = $parts[0];
            foreach (array_keys($tpl->getSections()) as $section) {
                $sections[$section][] = $zname;
            }
            $classes[$zname] = $class;
            $classes[$parts[0]] = $class;
            $classes[$zname]    = $class;
        }

        $args = array(
            'sections' => $sections,
            'tpls' => $this->compiled, 
            'classes' => $classes, 
            'namespace' => $this->ns,
            'list' => $tpls
        );
        return FixCode::fix(Templates\Templates::get("class")->render($args, true));
    }

    public function save($path)
    {
        if (file_put_contents($path, $this->GetCode(), LOCK_EX) === false) {
            throw new \RuntimeException("Error while writing to {$path}");
        }
        return $this;
    }

    public function compile()
    {
        $done = array();
        foreach ($this->env->files() as $file) {
            $this->compile_file($file);
            $done[] = $file;
        }
        return $done;
    }

}
