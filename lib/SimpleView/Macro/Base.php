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
namespace crodas\SimpleView\Macro;

use Simple_View_Parser as Parser;
use Simple_View_Args as Args;
use crodas\SimpleView\Template;

abstract class Base
{
    protected $body = null;
    protected $args = [];

    public function getType()
    {
        return Parser::T_PRE;
    }

    public function setBody(Template $body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function parseArgs($text)
    {
        $parser = new Args;
        $len    = strlen($text);
        for($i = 0; $i < $len; $i++) {
            switch ($text[$i]) {
            case ' ': case "\t": case "\n": 
                /* ignore whitespace */
                break;
            case ',':
                $parser->doParse(Args::T_COMMA, ',');
                break;
            case '=':
                $parser->doParse(Args::T_EQ, '=');
                break;
            case '"':
            case "'":
                $start  = $text[$i];
                $string = "";
                for (; ++$i < $len;) {
                    switch ($text[$i]) {
                    case $start:
                        break 2;
                    case '\\':
                        break;
                    default: 
                        $string .= $text[$i];
                    }
                }
                $parser->doParse(Args::T_STRING, $string);
                break;
            case '0': case '1': case '2': case '3': case '4':
            case '5': case '6': case '7': case '8': case '9':
                $start = $i;
                while (ctype_digit($text[++$i]) || $text[$i] == '.');
                $parser->doParse(Args::T_NUMBER, substr($text, $start, $i - $start));
                $i--;
                break;
            default:
                $start = $i;
                while (ctype_alpha($text[++$i]));
                $parser->doParse(Args::T_STRING, substr($text, $start, $i - $start));
                $i--;
            }
        }

        $parser->doParse(0, 0);

        $this->args = $parser->args;

        return $this;
    }

    abstract public function getNames();

    abstract public function run($context);

}
