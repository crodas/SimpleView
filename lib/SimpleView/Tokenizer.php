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

use Simple_View_Parser as Parser;

class Tokenizer
{
    public $commands = array(
        'elif'    => Parser::T_ELIF,
        'else'    => Parser::T_ELSE,
        'else if' => Parser::T_ELIF,
        'elseif'  => Parser::T_ELIF,
        'end'     => Parser::T_END,
        'extends' => Parser::T_EXTENDS,
        'foreach' => Parser::T_FOREACH,
        'if'      => Parser::T_IF,
        'include' => Parser::T_INCLUDE,
        'parent'  => Parser::T_PARENT,
        'section' => Parser::T_SECTION,
        'show'    => Parser::T_SHOW,
        'stop'    => Parser::T_END,
        'while'   => Parser::T_WHILE,
        'yield'   => Parser::T_YIELD,
        'unless'  => Parser::T_UNLESS,
    );

    public function getTokens($text)
    {
        ksort($this->commands);
        $len   = strlen($text);
        $start = '@'; 
        $tags  = array(
            'open' => '{{', 'close' => '}}',
            't_open' => '{{{', 't_close' => '}}}',
        );
        $tokens   = array();
        $notfound = 0xffffff;

        for ($i=0; $i < $len; $i++) {
            if ($text[$i] == $start) {
                $found = false;
                foreach ($this->commands as $command => $value) {
                    $cmp = strcasecmp($command, substr($text, $i+1, strlen($command)));
                    if ($cmp > 0) {
                        break;
                    }
                    if ($cmp === 0) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $tokens[] = array(Parser::T_TEXT_RAW, '@');
                } else {
                    $tokens[] = array($value, $command);
                    while (++$i < $len && $text[$i] != "\n" && $text[$i] != "(");
                    if ($i < $len && $text[$i] == '(') {
                        $count = 1;
                        $e = $i++;
                        while ($count > 0) {
                            switch ($text[++$e]) {
                            case '(': 
                                $count++;
                                break;
                            case ')':
                                $count--;
                                break;
                            case "\n";
                                throw new \Exception("Unexpected end of line");
                            }
                        }
                        $tokens[] = array(Parser::T_PHP_RAW, substr($text, $i, $e - $i));
                        $i = $e;
                        while (++$i < $len && $text[$i] != "\n");
                    }
                }
            } else if (
                    substr($text, $i, strlen($tags['open'])) == $tags['open'] ||
                    substr($text, $i, strlen($tags['t_open'])) == $tags['t_open']
                ) {
                if (substr($text, $i, strlen($tags['t_open'])) == $tags['t_open']) {
                    $open  = 't_open';
                    $close = 't_close';
                } else {
                    $open  = 'open';
                    $close = 'close';
                }

                $i  += strlen($tags[$open]);
                $end = $tags[$close]; 
                for ($e = $i; $e < $len; $e++) {
                    if ($text[$e] == '"' || $text[$e] == "'") {
                        $stop = $text[$e++];
                        for (; $e < $len; $e++) {
                            if ($text[$e] == "\\") continue;
                            if ($text[$e] == $stop) break;
                        }
                    } else if (substr($text, $e, strlen($end)) == $end) {
                        break;
                    }
                }
                if ($e == $len) {
                    throw new \Exception("Unexpected end of file");
                }
                $tokens[] = array($open == 'open' ? Parser::T_ECHO : Parser::T_ESCAPED_ECHO, substr($text, $i, $e - $i));
                $i = $e + strlen($tags[$close]) - 1;
            } else {
                $pos = min(array(
                    strpos($text, $start, $i) ?: $notfound,
                    strpos($text, $tags['open'], $i) ?: $notfound,
                    strpos($text, $tags['t_open'], $i) ?: $notfound,
                ));

                if ($pos === $notfound) {
                    $tokens[] = array(Parser::T_TEXT_RAW, substr($text, $i));
                    $i = $len;
                } else {
                    $raw_text = substr($text, $i, $pos - $i); 
                    if ($text[$pos] == $start) {
                        // clean up last line
                        $raw_text = rtrim($raw_text, " \t");
                    }
                    if (!empty($raw_text)) {
                        $tokens[] = array(Parser::T_TEXT_RAW, $raw_text);
                    }
                    $i = $pos-1;
                }
            }
        }

        return $tokens;
    }

}

