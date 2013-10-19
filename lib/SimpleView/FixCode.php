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

class FixCode
{
    public static function fix($content)
    {
        $tokens  = token_get_all($content);
        $tab  = "    ";
        $tabs = 0;
        $code = "";
        foreach ($tokens as $id => $token) {
            if (!is_array($token)) {
                switch ($token) {
                case '{':
                case '(':
                    $tabs++;
                    break;
                case '}':
                case ')':
                    $tabs--;
                    if ($code  !== ($tmp=rtrim($code, " \t")) && substr($tmp, -1) == "\n") {
                        $code  = $tmp;
                        $token = str_repeat($tab, $tabs) . $token;
                    }
                    break;
                }
                $code .= $token;
            } else {
                switch ($token[0]) {
                case T_CURLY_OPEN:
                    $tabs++;
                    break;
                case T_WHITESPACE:
                    $doTab = strpos($token[1], "\n") !== false
                        || (!empty($tokens[--$id]) && $tokens[$id][0] == T_COMMENT 
                            && $tokens[$id][1] != rtrim($tokens[$id][1], "\n"));
                    if ($doTab) {
                        $spaces = trim($token[1], " \t");
                        if ($tabs > 0) {
                            $spaces .= str_repeat($tab, $tabs);
                        }
                        $token[1] = $spaces;
                        if (!empty($tokens[$id+1]) && !empty($tokens[$id+1][1])) {
                            switch (strtolower($tokens[$id+1][1])) {
                            case 'default':
                            case 'case':
                                $token[1] = substr($spaces, 0, -1*strlen($tab));
                            }
                        }
                    }
                    break;
                }

                $code .= $token[1];
            }
        }
        return $code;
    }
}
