%name Simple_View_

%include {
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
use crodas\SimpleView\Exception;
}

%declare_class { class Simple_View_Parser }

%include_class {
    protected $lex;
    protected $file;

    function __construct($file='')
    {
        $this->file = $file;
    }

    function Error($text)
    {
        throw new Exception($text, -1);
    }

}

%parse_accept {
}

%syntax_error {
    $expected = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expected[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. ') expecting '. print_r($expected, true));
}

start ::= T_EXTENDS T_PHP_RAW(X) body(A) . { $this->body = array('extends', X, A); }
start ::= body(A) . { $this->body = A; }

body(A) ::= body(B) code(C) . { A = B; A[] = C; }
body(A) ::=  . { A = array(); }

code(A) ::= command(X) . { A = X; }
code(A) ::= T_ECHO(X) . { A = array('echo', X); }
code(A) ::= T_ESCAPED_ECHO(X) . { A = array('echox', X); }
code(A) ::= T_TEXT_RAW(X) . { A = array('text', X); }

command(A) ::= T_SET T_PHP_RAW(B) . { A = array('set', B); }
command(A) ::= T_FOREACH T_PHP_RAW(B) loop_body(C) T_END(X) . { A = array('foreach', B, C, @X); }
command(A) ::= T_WHILE T_PHP_RAW(B) loop_body(C) T_END(X) . { A = array('while', B, C, @X); }
command(A) ::= T_UNLESS T_PHP_RAW(B) body(C) T_END(X) . { A = array('unless', B, C, @X); }
command(A) ::= T_IF T_PHP_RAW(B) body(C) else(X) . { A = array('if', B, C, X); }
command(A) ::= T_SECTION T_PHP_RAW(B) body(C) T_END(X) . { A = array('section', B, C, @X); }
command(A) ::= T_SECTION T_PHP_RAW(B) body(C) T_SHOW . { A = array('section_and_show', B, C); }
command(A) ::= T_INCLUDE T_PHP_RAW(B) . { A = array('include', B); }
command(A) ::= T_YIELD T_PHP_RAW(B) . { A = array('yield', B); }
command(A) ::= T_PARENT . { A = array('parent'); }

loop_body(A) ::= loop_body(B) T_CONTINUE . { A = B; A[] = array('continue'); }
loop_body(A) ::= loop_body(B) code(X) . { A = B; A[] = X; }
loop_body(A) ::= . { A = array(); }


else(A) ::= T_ELIF T_PHP_RAW(Z) body(C) else(X) . { A = array('else if', Z, C, X); }
else(A) ::= T_ELSE body(C) T_END(X) . { A = array('else', C, @X); }
else(A) ::= T_END(X) . { A = @X; }
