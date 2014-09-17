<?php
/* Driver template for the PHP_Simple_View_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class Simple_View_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof Simple_View_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof Simple_View_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof Simple_View_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof Simple_View_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class Simple_View_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here
#line 3 "lib/SimpleView/Parser.y"

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
#line 137 "lib/SimpleView/Parser.php"

// declare_class is output here
#line 41 "lib/SimpleView/Parser.y"
 class Simple_View_Parser #line 142 "lib/SimpleView/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 43 "lib/SimpleView/Parser.y"

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

#line 162 "lib/SimpleView/Parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_EXTENDS                      =  1;
    const T_PHP_RAW                      =  2;
    const T_ECHO                         =  3;
    const T_NEWLINE                      =  4;
    const T_ESCAPED_ECHO                 =  5;
    const T_TEXT_RAW                     =  6;
    const T_SET                          =  7;
    const T_FOREACH                      =  8;
    const T_WHILE                        =  9;
    const T_UNLESS                       = 10;
    const T_IF                           = 11;
    const T_SECTION                      = 12;
    const T_SHOW                         = 13;
    const T_INCLUDE                      = 14;
    const T_YIELD                        = 15;
    const T_PARENT                       = 16;
    const T_BREAK                        = 17;
    const T_CONTINUE                     = 18;
    const T_SPACELESS                    = 19;
    const T_END                          = 20;
    const T_PRE_INLINE                   = 21;
    const T_PRE                          = 22;
    const T_ELIF                         = 23;
    const T_ELSE                         = 24;
    const YY_NO_ACTION = 94;
    const YY_ACCEPT_ACTION = 93;
    const YY_ERROR_ACTION = 92;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 165;
static public $yy_action = array(
 /*     0 */    51,   48,   47,   44,   29,   30,   35,   33,   32,   34,
 /*    10 */    22,   28,   27,   55,   56,   56,   16,   25,   31,   13,
 /*    20 */    26,   21,   51,   48,   47,   44,   29,   30,   35,   33,
 /*    30 */    32,   34,   60,   28,   27,   55,   56,   56,   16,   25,
 /*    40 */    31,   13,   51,   48,   47,   44,   29,   30,   35,   33,
 /*    50 */    32,   34,   57,   28,   27,   55,   56,   56,   16,   25,
 /*    60 */    31,   13,   51,   48,   47,   44,   29,   30,   35,   33,
 /*    70 */    32,   34,   58,   28,   27,   55,   56,   56,   16,   61,
 /*    80 */    31,   13,   51,   48,   47,   44,   29,   30,   35,   33,
 /*    90 */    32,   34,   11,   28,   27,   55,   56,   56,   16,   41,
 /*   100 */    31,   13,   49,   50,   36,   59,   54,   45,   49,   50,
 /*   110 */    36,   40,   54,   49,   50,   43,    2,   54,   49,   50,
 /*   120 */    46,   23,   54,   49,   50,   53,   20,   54,   17,   49,
 /*   130 */    50,   52,   18,   54,   49,   50,   42,    5,   54,   49,
 /*   140 */    50,   39,   14,   54,   49,   50,   38,   24,   54,   49,
 /*   150 */    50,   93,   12,   54,   37,   19,    8,   15,   10,    3,
 /*   160 */     6,    7,    9,    1,    4,
    );
    static public $yy_lookahead = array(
 /*     0 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*    10 */     2,   14,   15,   16,   17,   18,   19,   20,   21,   22,
 /*    20 */    23,   24,    3,    4,    5,    6,    7,    8,    9,   10,
 /*    30 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*    40 */    21,   22,    3,    4,    5,    6,    7,    8,    9,   10,
 /*    50 */    11,   12,    2,   14,   15,   16,   17,   18,   19,   20,
 /*    60 */    21,   22,    3,    4,    5,    6,    7,    8,    9,   10,
 /*    70 */    11,   12,    2,   14,   15,   16,   17,   18,   19,   20,
 /*    80 */    21,   22,    3,    4,    5,    6,    7,    8,    9,   10,
 /*    90 */    11,   12,   27,   14,   15,   16,   17,   18,   19,    2,
 /*   100 */    21,   22,   28,   29,   30,   31,   32,    2,   28,   29,
 /*   110 */    30,   31,   32,   28,   29,   30,   27,   32,   28,   29,
 /*   120 */    30,    2,   32,   28,   29,   30,    2,   32,    2,   28,
 /*   130 */    29,   30,    2,   32,   28,   29,   30,   27,   32,   28,
 /*   140 */    29,   30,    2,   32,   28,   29,   30,    1,   32,   28,
 /*   150 */    29,   26,   27,   32,    2,    2,   27,    2,   27,   27,
 /*   160 */    27,   27,   27,   27,   27,
);
    const YY_SHIFT_USE_DFLT = -4;
    const YY_SHIFT_MAX = 35;
    static public $yy_shift_ofst = array(
 /*     0 */   146,   -3,   -3,   19,   39,   39,   39,   39,   39,   39,
 /*    10 */    59,   79,   79,  155,   -4,   -4,   -4,   -4,   -4,   -4,
 /*    20 */    -4,   -4,   -4,   -4,  119,   97,    8,   50,   70,  105,
 /*    30 */   153,  152,  140,  130,  126,  124,
);
    const YY_REDUCE_USE_DFLT = -1;
    const YY_REDUCE_MAX = 23;
    static public $yy_reduce_ofst = array(
 /*     0 */   125,   74,   80,   85,   90,  101,  111,  106,  116,   95,
 /*    10 */   121,  121,  121,  134,  136,  133,  131,  132,  135,  137,
 /*    20 */   110,  129,   89,   65,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(1, ),
        /* 1 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 2 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 3 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 4 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 5 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 6 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 7 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 8 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 9 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 10 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, ),
        /* 11 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 21, 22, ),
        /* 12 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 21, 22, ),
        /* 13 */ array(2, ),
        /* 14 */ array(),
        /* 15 */ array(),
        /* 16 */ array(),
        /* 17 */ array(),
        /* 18 */ array(),
        /* 19 */ array(),
        /* 20 */ array(),
        /* 21 */ array(),
        /* 22 */ array(),
        /* 23 */ array(),
        /* 24 */ array(2, ),
        /* 25 */ array(2, ),
        /* 26 */ array(2, ),
        /* 27 */ array(2, ),
        /* 28 */ array(2, ),
        /* 29 */ array(2, ),
        /* 30 */ array(2, ),
        /* 31 */ array(2, ),
        /* 32 */ array(2, ),
        /* 33 */ array(2, ),
        /* 34 */ array(2, ),
        /* 35 */ array(2, ),
        /* 36 */ array(),
        /* 37 */ array(),
        /* 38 */ array(),
        /* 39 */ array(),
        /* 40 */ array(),
        /* 41 */ array(),
        /* 42 */ array(),
        /* 43 */ array(),
        /* 44 */ array(),
        /* 45 */ array(),
        /* 46 */ array(),
        /* 47 */ array(),
        /* 48 */ array(),
        /* 49 */ array(),
        /* 50 */ array(),
        /* 51 */ array(),
        /* 52 */ array(),
        /* 53 */ array(),
        /* 54 */ array(),
        /* 55 */ array(),
        /* 56 */ array(),
        /* 57 */ array(),
        /* 58 */ array(),
        /* 59 */ array(),
        /* 60 */ array(),
        /* 61 */ array(),
);
    static public $yy_default = array(
 /*     0 */    65,   92,   92,   92,   92,   92,   92,   92,   92,   92,
 /*    10 */    92,   62,   63,   65,   65,   65,   65,   65,   65,   65,
 /*    20 */    65,   65,   65,   65,   92,   90,   92,   92,   92,   92,
 /*    30 */    92,   92,   92,   92,   92,   92,   89,   84,   88,   85,
 /*    40 */    87,   91,   86,   76,   70,   71,   72,   69,   68,   64,
 /*    50 */    66,   67,   73,   74,   80,   81,   82,   79,   78,   75,
 /*    60 */    77,   83,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 34;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 62;
    const YYNRULE = 30;
    const YYERRORSYMBOL = 25;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx = -1;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'T_EXTENDS',     'T_PHP_RAW',     'T_ECHO',      
  'T_NEWLINE',     'T_ESCAPED_ECHO',  'T_TEXT_RAW',    'T_SET',       
  'T_FOREACH',     'T_WHILE',       'T_UNLESS',      'T_IF',        
  'T_SECTION',     'T_SHOW',        'T_INCLUDE',     'T_YIELD',     
  'T_PARENT',      'T_BREAK',       'T_CONTINUE',    'T_SPACELESS', 
  'T_END',         'T_PRE_INLINE',  'T_PRE',         'T_ELIF',      
  'T_ELSE',        'error',         'start',         'body',        
  'code',          'command',       'block_end',     'else',        
  'pre_processor',
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= T_EXTENDS T_PHP_RAW body",
 /*   1 */ "start ::= body",
 /*   2 */ "body ::= body code",
 /*   3 */ "body ::=",
 /*   4 */ "code ::= command",
 /*   5 */ "code ::= T_ECHO",
 /*   6 */ "code ::= T_NEWLINE",
 /*   7 */ "code ::= T_ESCAPED_ECHO",
 /*   8 */ "code ::= T_TEXT_RAW",
 /*   9 */ "command ::= T_SET T_PHP_RAW",
 /*  10 */ "command ::= T_FOREACH T_PHP_RAW body block_end",
 /*  11 */ "command ::= T_WHILE T_PHP_RAW body block_end",
 /*  12 */ "command ::= T_UNLESS T_PHP_RAW body block_end",
 /*  13 */ "command ::= T_IF T_PHP_RAW body else",
 /*  14 */ "command ::= T_SECTION T_PHP_RAW body block_end",
 /*  15 */ "command ::= T_SECTION T_PHP_RAW body T_SHOW",
 /*  16 */ "command ::= T_INCLUDE T_PHP_RAW",
 /*  17 */ "command ::= T_YIELD T_PHP_RAW",
 /*  18 */ "command ::= pre_processor",
 /*  19 */ "command ::= T_PARENT",
 /*  20 */ "command ::= T_BREAK|T_CONTINUE",
 /*  21 */ "command ::= T_SPACELESS body T_END",
 /*  22 */ "pre_processor ::= T_PRE_INLINE T_PHP_RAW",
 /*  23 */ "pre_processor ::= T_PRE T_PHP_RAW body block_end",
 /*  24 */ "pre_processor ::= T_PRE body block_end",
 /*  25 */ "else ::= T_ELIF T_PHP_RAW body else",
 /*  26 */ "else ::= T_ELSE body block_end",
 /*  27 */ "else ::= block_end",
 /*  28 */ "block_end ::= T_END",
 /*  29 */ "block_end ::= T_END T_PHP_RAW",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param Simple_View_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Simple_View_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Simple_View_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
            return;
        }
        $yytos = new Simple_View_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for ($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 26, 'rhs' => 3 ),
  array( 'lhs' => 26, 'rhs' => 1 ),
  array( 'lhs' => 27, 'rhs' => 2 ),
  array( 'lhs' => 27, 'rhs' => 0 ),
  array( 'lhs' => 28, 'rhs' => 1 ),
  array( 'lhs' => 28, 'rhs' => 1 ),
  array( 'lhs' => 28, 'rhs' => 1 ),
  array( 'lhs' => 28, 'rhs' => 1 ),
  array( 'lhs' => 28, 'rhs' => 1 ),
  array( 'lhs' => 29, 'rhs' => 2 ),
  array( 'lhs' => 29, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 2 ),
  array( 'lhs' => 29, 'rhs' => 2 ),
  array( 'lhs' => 29, 'rhs' => 1 ),
  array( 'lhs' => 29, 'rhs' => 1 ),
  array( 'lhs' => 29, 'rhs' => 1 ),
  array( 'lhs' => 29, 'rhs' => 3 ),
  array( 'lhs' => 32, 'rhs' => 2 ),
  array( 'lhs' => 32, 'rhs' => 4 ),
  array( 'lhs' => 32, 'rhs' => 3 ),
  array( 'lhs' => 31, 'rhs' => 4 ),
  array( 'lhs' => 31, 'rhs' => 3 ),
  array( 'lhs' => 31, 'rhs' => 1 ),
  array( 'lhs' => 30, 'rhs' => 1 ),
  array( 'lhs' => 30, 'rhs' => 2 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        18 => 4,
        28 => 4,
        29 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        11 => 11,
        12 => 12,
        13 => 13,
        14 => 14,
        15 => 15,
        16 => 16,
        17 => 17,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        27 => 27,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 70 "lib/SimpleView/Parser.y"
    function yy_r0(){ $this->body = array('extends', $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 969 "lib/SimpleView/Parser.php"
#line 71 "lib/SimpleView/Parser.y"
    function yy_r1(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 972 "lib/SimpleView/Parser.php"
#line 73 "lib/SimpleView/Parser.y"
    function yy_r2(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 975 "lib/SimpleView/Parser.php"
#line 74 "lib/SimpleView/Parser.y"
    function yy_r3(){ $this->_retvalue = array();     }
#line 978 "lib/SimpleView/Parser.php"
#line 76 "lib/SimpleView/Parser.y"
    function yy_r4(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 981 "lib/SimpleView/Parser.php"
#line 77 "lib/SimpleView/Parser.y"
    function yy_r5(){ 
    $this->yystack[$this->yyidx + 0]->minor = trim($this->yystack[$this->yyidx + 0]->minor); 
    $this->_retvalue = array('echo', $this->yystack[$this->yyidx + 0]->minor);
    }
#line 987 "lib/SimpleView/Parser.php"
#line 81 "lib/SimpleView/Parser.y"
    function yy_r6(){ $this->_retvalue = array('newline', $this->yystack[$this->yyidx + 0]->minor);     }
#line 990 "lib/SimpleView/Parser.php"
#line 82 "lib/SimpleView/Parser.y"
    function yy_r7(){ $this->_retvalue = array('echox', trim($this->yystack[$this->yyidx + 0]->minor));     }
#line 993 "lib/SimpleView/Parser.php"
#line 83 "lib/SimpleView/Parser.y"
    function yy_r8(){ $this->_retvalue = array('text', $this->yystack[$this->yyidx + 0]->minor);     }
#line 996 "lib/SimpleView/Parser.php"
#line 85 "lib/SimpleView/Parser.y"
    function yy_r9(){ $this->_retvalue = array('set', $this->yystack[$this->yyidx + 0]->minor);     }
#line 999 "lib/SimpleView/Parser.php"
#line 86 "lib/SimpleView/Parser.y"
    function yy_r10(){ $this->_retvalue = array('foreach', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1002 "lib/SimpleView/Parser.php"
#line 87 "lib/SimpleView/Parser.y"
    function yy_r11(){ $this->_retvalue = array('while', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1005 "lib/SimpleView/Parser.php"
#line 88 "lib/SimpleView/Parser.y"
    function yy_r12(){ $this->_retvalue = array('unless', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1008 "lib/SimpleView/Parser.php"
#line 89 "lib/SimpleView/Parser.y"
    function yy_r13(){ $this->_retvalue = array('if', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1011 "lib/SimpleView/Parser.php"
#line 90 "lib/SimpleView/Parser.y"
    function yy_r14(){ $this->_retvalue = array('section', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1014 "lib/SimpleView/Parser.php"
#line 91 "lib/SimpleView/Parser.y"
    function yy_r15(){ $this->_retvalue = array('section_and_show', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1017 "lib/SimpleView/Parser.php"
#line 92 "lib/SimpleView/Parser.y"
    function yy_r16(){ $this->_retvalue = array('include', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1020 "lib/SimpleView/Parser.php"
#line 93 "lib/SimpleView/Parser.y"
    function yy_r17(){ $this->_retvalue = array('yield', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1023 "lib/SimpleView/Parser.php"
#line 95 "lib/SimpleView/Parser.y"
    function yy_r19(){ $this->_retvalue = array('parent');     }
#line 1026 "lib/SimpleView/Parser.php"
#line 96 "lib/SimpleView/Parser.y"
    function yy_r20(){ $this->_retvalue = array(strtolower(@$this->yystack[$this->yyidx + 0]->minor));     }
#line 1029 "lib/SimpleView/Parser.php"
#line 97 "lib/SimpleView/Parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('spaceless', $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);
    }
#line 1034 "lib/SimpleView/Parser.php"
#line 101 "lib/SimpleView/Parser.y"
    function yy_r22(){ $this->_retvalue = array('pre', @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor, NULL, NULL);     }
#line 1037 "lib/SimpleView/Parser.php"
#line 102 "lib/SimpleView/Parser.y"
    function yy_r23(){ $this->_retvalue = array('pre', @$this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1040 "lib/SimpleView/Parser.php"
#line 103 "lib/SimpleView/Parser.y"
    function yy_r24(){ $this->_retvalue = array('pre', @$this->yystack[$this->yyidx + -2]->minor, NULL, $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1043 "lib/SimpleView/Parser.php"
#line 105 "lib/SimpleView/Parser.y"
    function yy_r25(){ $this->_retvalue = array('else if', $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1046 "lib/SimpleView/Parser.php"
#line 106 "lib/SimpleView/Parser.y"
    function yy_r26(){ $this->_retvalue = array('else', $this->yystack[$this->yyidx + -1]->minor, @$this->yystack[$this->yyidx + 0]->minor);     }
#line 1049 "lib/SimpleView/Parser.php"
#line 107 "lib/SimpleView/Parser.y"
    function yy_r27(){ $this->_retvalue = @$this->yystack[$this->yyidx + 0]->minor;     }
#line 1052 "lib/SimpleView/Parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //Simple_View_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for ($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new Simple_View_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 62 "lib/SimpleView/Parser.y"

    $expected = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expected[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. ') expecting '. print_r($expected, true));
#line 1172 "lib/SimpleView/Parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line 59 "lib/SimpleView/Parser.y"

#line 1193 "lib/SimpleView/Parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int   $yymajor      the token number
     * @param mixed $yytokenvalue the token value
     * @param mixed ...           any extra arguments that should be passed to handlers
     *
     * @return void
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new Simple_View_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(
                self::$yyTraceFILE,
                "%sInput %s\n",
                self::$yyTracePrompt,
                self::$yyTokenName[$yymajor]
            );
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL
                && !$this->yy_is_expected_token($yymajor)
            ) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(
                        self::$yyTraceFILE,
                        "%sSyntax Error!\n",
                        self::$yyTracePrompt
                    );
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ) {
                        if (self::$yyTraceFILE) {
                            fprintf(
                                self::$yyTraceFILE,
                                "%sDiscard input token %s\n",
                                self::$yyTracePrompt,
                                self::$yyTokenName[$yymajor]
                            );
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0
                            && $yymx != self::YYERRORSYMBOL
                            && ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                        ) {
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}
