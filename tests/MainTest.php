<?php

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
        $output = \Tests\Templates::get($tpl)->render($args, true);
        $this->assertEquals($expected, $output);
    }
}
