<?php

class foobar extends RuntimeException {}

function failure()
{
    throw new foobar;
}

class MainTest extends \phpunit_framework_testcase
{
    public static function provider()
    {
        $files = glob(__DIR__ . '/views/*.output');
        return array_map(function($row) {
            $dir  = dirname($row);
            $name = substr(basename($row), 0, -7);
            $args = array();
            $args_file =  $dir . '/' . $name . '.data';
            if (is_file($args_file)) {
                $args = json_decode(file_get_contents($args_file), true);
            }
            return array($name, $args, file_get_contents($row));
        }, $files);
    }

    /**
     *  @dataProvider provider
     */
    public function testCompile($tpl, $args, $expected)
    {
        try {
            $output = \Tests\Templates::get($tpl)->render($args, true);
            $this->assertEquals($expected, $output);
        } catch (foobar $e) {
            $this->assertTrue(True);
        }
    }

    public function testSection()
    {
        $tpl = \Tests\Templates::get('extends');
        $this->assertEquals(trim($tpl->renderSection('foobar')), "hi there!");
    }

    public function testLoop() 
    {
        $user = array('name' => 'foobar', 'has_session' => false);
        $output = \Tests\Templates::get('unless')->render(compact('user'), true);
        $this->assertEquals($output, "Hi foobar\n    you must login\n");

        $user = array('name' => 'foobar', 'has_session' => true);
        $output = \Tests\Templates::get('unless')->render(compact('user'), true);
        $this->assertEquals($output, "Hi foobar\n");
    }

}
