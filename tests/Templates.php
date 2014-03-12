<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */

namespace {

    class base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
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
    class class_75b4a0fe9cd1d6711cc7dec092e958edbe1efc00 extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
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
     *  Template class generated from at.tpl.php
     */
    class class_eef20d69ae52eb9005a515c213ab9554791979c9 extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            var_export(['foo', 'bar']);
            echo "\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from layout.tpl.php
     */
    class class_bf6970c3f5699b979a3692d8261f22d15fadad5a extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
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
    class class_19709c42e2300830673895009607ec98d96822ec extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
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

            $template = Tests\Templates::get("extends");
            $template->child = $this;
            $this->parent = $template;
            return $template->render($vars, $return);

        }
    }

    /** 
     *  Template class generated from while.tpl.php
     */
    class class_6e15d2af65fcf7798021e9323798f193499ac09d extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            while ($i < 10) {
                echo "    hi " . (++$i) . "\n";
            }

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from loop.tpl.php
     */
    class class_d481f16a4eb3add789581f97f6600c2a74a9d0a8 extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            foreach($users as $id => $user1) {
                $this->context['id'] = $id;
                $this->context['user1'] = $user1;
                $user = $user1;
                $this->context['user'] = $user;
                echo "    hi " . ($user) . "\n";
                $foo = 'xxx';
                $this->context['foo'] = $foo;
                if ($user == 1) {
                    continue;
                }
            }
            foreach($users as $user1) {
                $this->context['user1'] = $user1;
                echo "    hi " . ($user1) . "\n";
                break;
            }

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from home.tpl.php
     */
    class class_6caefdda43fcb619b729c17289d5237e623d208b extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
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
    class class_253d6a60b264956df48ba486a3d7908285d7ece5 extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            Tests\Templates::exec('if', $this->context);

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from extends.tpl.php
     */
    class class_793a0eb11fa5c92b689ad190f2f86f14ac827463 extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
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

            $template = Tests\Templates::get("layout.tpl.php");
            $template->child = $this;
            $this->parent = $template;
            return $template->render($vars, $return);

        }
    }

    /** 
     *  Template class generated from unless.tpl.php
     */
    class class_06bb1727fc549c9b2df4fe8a4d8f08d53ca2a1c8 extends base_template_39fdec1194d94212b871a28b2aa04a73cd40fce1
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "Hi " . ($user['name']) . "\n";
            if (!($user['has_session'])) {
                echo "    you must login\n";
            }

            if ($return) {
                return ob_get_clean();
            }

        }
    }

}

namespace Tests {

    class Templates
    {
        public static function getAll()
        {
            return array (
                0 => 'if',
                1 => 'at',
                2 => 'layout',
                3 => 'extends_extends',
                4 => 'while',
                5 => 'loop',
                6 => 'home',
                7 => 'if1',
                8 => 'extends',
                9 => 'unless',
            );
        }

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
                'at.tpl.php' => 'class_eef20d69ae52eb9005a515c213ab9554791979c9',
                'at' => 'class_eef20d69ae52eb9005a515c213ab9554791979c9',
                'layout.tpl.php' => 'class_bf6970c3f5699b979a3692d8261f22d15fadad5a',
                'layout' => 'class_bf6970c3f5699b979a3692d8261f22d15fadad5a',
                'extends_extends.tpl.php' => 'class_19709c42e2300830673895009607ec98d96822ec',
                'extends_extends' => 'class_19709c42e2300830673895009607ec98d96822ec',
                'while.tpl.php' => 'class_6e15d2af65fcf7798021e9323798f193499ac09d',
                'while' => 'class_6e15d2af65fcf7798021e9323798f193499ac09d',
                'loop.tpl.php' => 'class_d481f16a4eb3add789581f97f6600c2a74a9d0a8',
                'loop' => 'class_d481f16a4eb3add789581f97f6600c2a74a9d0a8',
                'home.tpl.php' => 'class_6caefdda43fcb619b729c17289d5237e623d208b',
                'home' => 'class_6caefdda43fcb619b729c17289d5237e623d208b',
                'if1.tpl.php' => 'class_253d6a60b264956df48ba486a3d7908285d7ece5',
                'if1' => 'class_253d6a60b264956df48ba486a3d7908285d7ece5',
                'extends.tpl.php' => 'class_793a0eb11fa5c92b689ad190f2f86f14ac827463',
                'extends' => 'class_793a0eb11fa5c92b689ad190f2f86f14ac827463',
                'unless.tpl.php' => 'class_06bb1727fc549c9b2df4fe8a4d8f08d53ca2a1c8',
                'unless' => 'class_06bb1727fc549c9b2df4fe8a4d8f08d53ca2a1c8',
            );
            $name = strtolower($name);
            if (empty($classes[$name])) {
                throw new \RuntimeException("Cannot find template $name");
            }

            $class = "\\" . $classes[$name];
            return new $class;
        }
    }

}
