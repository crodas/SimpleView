<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */

namespace Tests;

class base_template
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

/** 
 *  Template class generated from if.tpl.php
 */
class class_75b4a0fe9cd1d6711cc7dec092e958edbe1efc00 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "Hi ";
        echo htmlentities($name, ENT_QUOTES, 'UTF-8', false);
        echo "\n";
        if ($age < 18) {
            echo "    You cannot be here\n";
        }
        else {
            echo "    Welcome!\n";
        }

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from layout.tpl.php
 */
class class_bf6970c3f5699b979a3692d8261f22d15fadad5a extends base_template
{
    protected function section_594fd1615a341c77829e83ed988f137e1ba96231($context)
    {
        extract($context);
        echo "<h1>Hi</h1>\n";
    }
    protected function section_8843d7f92416211de9ebb963ff4ce28125932878($context)
    {
        extract($context);
        echo "    Nothing here\n";
    }

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "\n";
        $this->do_yield('header');
        echo "\n<content>\n";
        $this->do_yield('foobar');
        echo "</content>\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from extends_extends.tpl.php
 */
class class_19709c42e2300830673895009607ec98d96822ec extends base_template
{
    protected function section_594fd1615a341c77829e83ed988f137e1ba96231($context)
    {
        extract($context);
        $this->yield_parent('header', $context);
        echo "<h1>Bye</h1>\n";
    }
    protected function section_8843d7f92416211de9ebb963ff4ce28125932878($context)
    {
        extract($context);
        $this->yield_parent('foobar', $context);
        echo "    Bye there!\n";
    }

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        $template = Templates::get("extends");
        $template->child = $this;
        $this->parent = $template;
        return $template->render($vars, $return);

    }
}

/** 
 *  Template class generated from home.tpl.php
 */
class class_6caefdda43fcb619b729c17289d5237e623d208b extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "Hello world\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from if1.tpl.php
 */
class class_253d6a60b264956df48ba486a3d7908285d7ece5 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        Templates::exec('if', $this->context);

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from extends.tpl.php
 */
class class_793a0eb11fa5c92b689ad190f2f86f14ac827463 extends base_template
{
    protected function section_8843d7f92416211de9ebb963ff4ce28125932878($context)
    {
        extract($context);
        $this->yield_parent('foobar', $context);
        echo "    hi there!\n";
    }

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        $template = Templates::get("layout.tpl.php");
        $template->child = $this;
        $this->parent = $template;
        return $template->render($vars, $return);

    }
}


class Templates
{
    public static function exec($name, Array $context = array(), Array $global = array())
    {
        $tpl = self::get($name);
        return $tpl->render(array_merge($global, $context));
    }

    public static function get($name, Array $context = array())
    {
        static $classes = array (
            'if.tpl.php' => 'class_75b4a0fe9cd1d6711cc7dec092e958edbe1efc00',
            'if' => 'class_75b4a0fe9cd1d6711cc7dec092e958edbe1efc00',
            'layout.tpl.php' => 'class_bf6970c3f5699b979a3692d8261f22d15fadad5a',
            'layout' => 'class_bf6970c3f5699b979a3692d8261f22d15fadad5a',
            'extends_extends.tpl.php' => 'class_19709c42e2300830673895009607ec98d96822ec',
            'extends_extends' => 'class_19709c42e2300830673895009607ec98d96822ec',
            'home.tpl.php' => 'class_6caefdda43fcb619b729c17289d5237e623d208b',
            'home' => 'class_6caefdda43fcb619b729c17289d5237e623d208b',
            'if1.tpl.php' => 'class_253d6a60b264956df48ba486a3d7908285d7ece5',
            'if1' => 'class_253d6a60b264956df48ba486a3d7908285d7ece5',
            'extends.tpl.php' => 'class_793a0eb11fa5c92b689ad190f2f86f14ac827463',
            'extends' => 'class_793a0eb11fa5c92b689ad190f2f86f14ac827463',
        );
        $name = strtolower($name);
        if (empty($classes[$name])) {
            throw new \RuntimeException("Cannot find template $name");
        }
        $class = __NAMESPACE__ .  "\\" . $classes[$name];
        return new $class;
    }
}
