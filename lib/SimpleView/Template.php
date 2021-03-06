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

use crodas\SimpleView\Macro\AssetInline;

class Template
{
    protected $stmts;
    protected $section = "main";

    protected $source = '';

    protected $env;
    protected $sections = array();
    protected $codes = array();
    protected $parent;
    protected $loop;
    protected $spaceless = false;

    public function __construct(Array $stmts, Environment $env, $section = null, $loop = false, $spaceless = false)
    {
        $this->env     = $env;
        $this->stmts   = $stmts;
        $this->section = $section;
        $this->loop    = $loop;
        $this->spaceless = $spaceless;
        $this->doProcess($stmts);
    }

    public function getParent()
    {
        return $this->parent;
    }

    protected function parseArguments($raw)
    {
        $args = [];
        $len  = strlen($raw);
        $buf  = 0;
        $ind  = 0;
        for ($i=0; $i < $len; $i++) {
            switch ($raw[$i]) {
            case '(':
            case '[':
                $ind++;
                break;
            case ')':
            case ']':
                $ind--;
                break;
            case ',':
                if ($ind == 0) {
                    $args[] = trim(substr($raw, $buf, $i - $buf)); 
                    $buf    = $i+1;
                }
            }
        }

        $args[] = trim(substr($raw, $buf, $i - $buf)); 

        return array_filter($args);
    }

    /**
     *  @TODO: Must check the stmt is a string and not an expr.
     */
    protected function getString($stmt)
    {
        return trim($stmt, "'\"");
    }

    protected function stringify($stmt)
    {
        $text = addslashes($stmt);
        if ($this->spaceless) {
            $regex = array(
                '/>[ \t\r\n]+</smU',
                '/[ \t\r\n]+</smU',
                '/>[ \t\r\n]/smU',
            );
            $repl  = array('><', '<', '>');
            $text = preg_replace($regex, $repl, trim($text));
        }
        return '"' . str_replace(array("\t", "\n", '$', "\\'"), array('\t', '\n','\$', "'"), $text) . '"';
    }

    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    protected function doProcess($stmts)
    {
        if ($stmts && $stmts[0] == 'extends') {
            $this->parent = $stmts[1];
            $stmts = $stmts[2];
        }

        $block  = &$this->codes;

        foreach ($stmts as $id => $stmt) {
            switch ($stmt[0]) {
            case 'text':
                if (is_array(end($block)) && end($block)[0] == 'echo') {
                    $block[ count($block) - 1 ][1] .= " . " . $this->stringify($stmt[1]);
                } else {
                    $block[] = array('echo', $this->stringify($stmt[1]));
                }
                break;
            case 'spaceless':
                $block[] = array('spaceless', new self($stmt[1], $this->env, null, $this->loop, true));
                break;

            case 'echox':
            case 'echo':
                if ($stmt[1][0]  == '@') {
                    $stmt[0] = 'var_export';
                    $stmt[1] = substr($stmt[1], 1);
                }
                if (!empty(AssetInline::$assets[$stmt[1]])) {
                    $stmt[1] = AssetInline::$assets[$stmt[1]];
                }
                if (is_array(end($block)) && end($block)[0] == $stmt[0]) {
                    $block[ count($block) - 1 ][1] .= " . (" . $stmt[1] . ")";
                } else {
                    $block[] = array($stmt[0], $stmt[1]);
                }
                break;
            case 'if':
                $if = array('if', $stmt[1], new self($stmt[2], $this->env, null, $this->loop, $this->spaceless));
                if (!empty($stmt[3]) && !is_string($stmt[3])) {
                    $if[] = new self([ $stmt[3] ], $this->env, null, $this->loop, $this->spaceless);
                }
                $block[] =  $if;
                break;
            case 'else if':
                $if = array('elseif', $stmt[1], new self($stmt[2], $this->env, null, $this->loop, $this->spaceless));
                if (!empty($stmt[3]) && !is_string($stmt[3])) {
                    $if[] = new self([ $stmt[3] ], $this->env, null, $this->loop, $this->spaceless);
                }
                $block[] =  $if;
                break;
            case 'else':
                $block[] = array('else', new self($stmt[1], $this->env, null, $this->loop, $this->spaceless));
                break;

            case 'foreach':
            case 'unless':
            case 'while':
                $end  = 'end' . strtolower($stmt[0]);
                $body = new Template($stmt[2], $this->env, null, true);
                $block[] = array($stmt[0], $stmt[1], $body);
                switch (strtolower($stmt[3])) {
                case 'end':
                case 'stop':
                case $end:
                    break;
                default:
                    throw new \RuntimeException("Unexpected {$stmt[3]}, expecting @end, @stop or @endforeach");
                }
                break;
            case 'newline':
                $skip = false;

                foreach ([$id-1, $id+1] as $i) {
                    if (!empty($stmts[$i])) {
                        $next = $stmts[$i];
                        if (in_array($next[0], array('break', 'continue'))) {
                            $skip = true;
                            break;
                        }
                    }
                }

                if (empty($skip)) {
                    $block[] = array('newline', $stmt[1]);
                }
                break;

            case 'section_and_show':
                $section = $this->getString($stmt[1]);
                $this->sections[$section] = new Template($stmt[2], $this->env, $section);
                $block[] = array('yield', var_Export($section, true));

                break;
            case 'section':
                $section = $this->getString($stmt[1]);
                $this->sections[$section] = new Template($stmt[2], $this->env, $section);
                break;
            case 'yield':
            case 'include':
                $block[] = $stmt;
                break;

            case 'continue':
            case 'break';
                if (!$this->loop) {
                    throw new \RuntimeException("You cannot call {$stmt[0]} outside of an loop");
                }
                $block[] = $stmt;
                break;
            case 'set':
                $args = $this->parseArguments($stmt[1]);
                if (count($args) !== 2) {
                    throw new \RuntimeException("@set expects two arguments");
                }
                if ($args[0][0] !== '$') {
                    throw new \RuntimeException("@set's first argument must be a variable");
                }

                $block[] = array('set', $args[0], $args[1]);

                break;
            case 'parent':
                if (!$this->section) {
                    throw new \RuntimeException("You cannot call @parent outside of a @section");
                }
                $block[] = array('parent', var_export($this->section, true));

                break;
            case 'pre':
                $macros = $this->env->getMacrosObjects();
                if (empty($macros[$stmt[1]])) {
                    throw new \RuntimeException("Cannot find Macro for {$stmt[1]}");
                }
                $macro = $macros[$stmt[1]];
                $new   = new $macro($this->env);
                if (!empty($stmt[2])) {
                    $new->parseArgs($stmt[2]);
                }
                if (!empty($stmt[3])) {
                    $child = new self($stmt[3], $this->env, null, $this->loop, $this->spaceless);
                    $new->setBody($child);
                }
                $new->prepare();
                $block[] = $new;
                break;

            default:
                throw new \Exception("{$stmt[0]} is not implemented yet. " . print_r($stmt, true));
            }
        }
    }
    
    public function getStmts()
    {
        return $this->codes;
    }

    public function getSections()
    {
        return $this->sections;
    }

}
