<?php
use crodas\SimpleView\Environment;
use crodas\SimpleView\Compiler;
use crodas\SimpleView\Exception;
use Symfony\Component\Finder\Finder;

class ErrorTest extends \phpunit_framework_testcase
{
    public function testTokenizerException()
    {
        $finder   = new Finder;
        $finder->files()
            ->name("foobar.tpl.php")->in(__DIR__ . '/error');
        $compiler = new Compiler(new Environment($finder));
        $compiler->setNamespace('Tests');
        try {
            $compiler->compile();
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals($e->getLine(), 5);
            $this->assertEquals(substr($e->getFile(), -14), 'foobar.tpl.php');
        }
    }

    public function testParserException()
    {
        $finder   = new Finder;
        $finder->files()
            ->name("parser.tpl.php")->in(__DIR__ . '/error');
        $compiler = new Compiler(new Environment($finder));
        $compiler->setNamespace('Tests');
        try {
            $compiler->compile();
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals($e->getLine(), 8);
            $this->assertEquals(substr($e->getFile(), -14), 'parser.tpl.php');
        }
    }

    public function testParser2Exception()
    {
        $finder   = new Finder;
        $finder->files()
            ->name("parser2.tpl.php")->in(__DIR__ . '/error');
        $compiler = new Compiler(new Environment($finder));
        $compiler->setNamespace('Tests');
        try {
            $compiler->compile();
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals($e->getLine(), 6);
            $this->assertEquals(substr($e->getFile(), -15), 'parser2.tpl.php');
        }
    }
}
