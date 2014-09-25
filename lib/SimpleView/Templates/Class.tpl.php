<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */

namespace {

@set($hash, uniqid())

$GLOBALS['file_{{$hash}}'] = array();
$GLOBALS['line_{{$hash}}'] = array();

class base_template_{{ sha1($namespace) }}
{
    protected $parent;
    protected $child;
    protected $context;

    public function yield_parent($name, $args)
    {
        $method = "section_" . sha1($name);

        if (is_callable(array($this->parent, $method))) {
            $this->parent->$method(array_merge($this->context, $args));
            return true;
        }

        if ($this->parent) {
            return $this->parent->yield_parent($name, $args);
        }

        return false;
    }

    public function do_yield($name, Array $args = array())
    {
        if ($this->child) {
            // We have a children template, we are their base
            // so let's see if they have implemented by any change
            // this section
            if ($this->child->do_yield($name, $args)) {
                // yes!
                return true;
            }
        }

        // Do I have this section defined?
        $method = "section_" . sha1($name);
        if (is_callable(array($this, $method))) {
            // Yes!
            $this->$method(array_merge($this->context, $args));
            return true;
        }

        // No :-(
        return false;
    }

}

@foreach($tpls as $name => $tpl)
    /** 
     *  Template class generated from {{ $tpl->getSource() }}
     */
class class_{{sha1($name)}} extends base_template_{{ sha1($namespace) }}
{
    @foreach ($tpl->getSections() as $name => $code)
    protected function section_{{sha1($name)}}($context)
    {
        global $file_{{$hash}}, $line_{{$hash}};
        extract($context);
        $_{{$hash}} = array_push($file_{{$hash}}, {{@$name}}) - 1;
        $line_{{$hash}}[$_{{$hash}}] = 1;
        @include("body", array('tpl' => $code))
        array_pop($file_{{$hash}});
    }
    @end

    public function renderSection($name, Array $args = array(), $fail_on_missing = true)
    {
        ob_start();
        switch ($name) {
        @foreach ($tpl->getSections() as $name => $code)
        case {{@$name}}:
            try {
                $this->section_{{sha1($name)}}($args);
            } catch (Exception $e) {
                ob_get_clean();
                throw $e;
            }
            break;

        @end

        default:
            if ($fail_on_missing) {
                throw new \RuntimeException("Cannot find section {$name}");
            }
        }

        return ob_get_clean();
    }

    public function render(Array $vars = array(), $return = false)
    {
        try { 
            return $this->_render($vars, $return);
        } catch (\Exception $e) {
            if ($return) ob_get_clean();
            throw new {{$namespace}}\ExceptionWrapper($e, __FILE__);
        }
    }

    public function _render(Array $vars = array(), $return = false)
    {
        global $file_{{$hash}}, $line_{{$hash}};
        $this->context = $vars;

        @if ($tpl->getParent())
        $template = {{$namespace}}\Templates::get({{ $tpl->getParent() }});
        $template->child = $this;
        $this->parent = $template;
        return $template->render($vars, $return);

        @else
        extract($vars);
        if ($return) {
            ob_start();
        }
        $_{{$hash}} = array_push($file_{{$hash}}, {{@$name}}) - 1;
        $line_{{$hash}}[$_{{$hash}}] = 1;

        @include("body", array('tpl' => $tpl))

        array_pop($file_{{$hash}});

        if ($return) {
            return ob_get_clean();
        }

        @endif
    }
}

@end
}

namespace {{$namespace}} {

use Exception;

class ExceptionWrapper extends Exception
{
    public $e;
    protected $file;

    public function getSimpleViewTrace()
    {
        global $file_{{$hash}}, $line_{{$hash}};

        $traces = $this->e->getTrace();
        $i = 0;
        foreach ($traces as &$trace) {
            if (!empty($trace['file']) 
              && $trace['file'] == $this->file && !empty($file_{{$hash}}[$i])) {
                $trace['file'] = $file_{{$hash}}[$i];
                $trace['line'] = $line_{{$hash}}[$i];
                ++$i;
            }
            if (empty($trace['file'])) {
                $trace['file'] = '[internal function]';
            } 
            if (empty($trace['line'])) {
                $trace['line'] = '';
            }
        }

        return $traces;
    }

    public function __toString()
    {
        $traces = $this->getSimpleViewTrace();
        $str    = "exception '" . get_class($this->e) . "' in {$traces[0]['file']}{$traces[0]['line']}:\nStack trace:\n";
        foreach ($traces as $i => $trace) {
            $str .= "#{$i} {$trace['file']}:{$trace['line']}\n";
        }
        ++$i;
        $str .= "#{$i} {main}";
        return $str;
    }

    public function __construct(Exception $e, $file)
    {
        $this->e    = $e;
        $this->file = $file;
    }
}


class Templates
{
    public static function getAll()
    {
        return {{@$list}};
    }

    public static function exec($name, Array $context = array(), Array $global = array())
    {
        $tpl = self::get($name);
        return $tpl->render(array_merge($global, $context));
    }

    public static function get($name, Array $context = array())
    {
        static $classes = {{ @$classes }};
        $name = strtolower($name);
        if (empty($classes[$name])) {
            throw new \RuntimeException("Cannot find template $name");
        }

        $class = "\\" . $classes[$name];
        return new $class;
    }
}

}
