<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */

namespace {

    class base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
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
     *  Template class generated from Parent.tpl.php
     */
    class class_5d7cda60ed67317c63462a7a3f97c1eaa6a18d4e extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "\$this->yield_parent(" . ($token[1]) . ", \$context);\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Echox.tpl.php
     */
    class class_b3f21f4b7452906b330612b966219cc089b11145 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "echo htmlentities(" . ( $token[1] ) . ", ENT_QUOTES, 'UTF-8', false);\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Body.tpl.php
     */
    class class_399877791885ad1a9fde51bca4deb52107f94699 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            foreach($tpl->getStmts() as $token) {
                crodas\SimpleView\Templates\Templates::exec($token[0], array('token' => $token ), $this->context);
            }

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Unless.tpl.php
     */
    class class_f5ab41dedb21a24081861ee6a36af5e59365a600 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "if (!(" . ($token[1]) . ")) {\n";
            crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $token[2]), $this->context);
            echo "}\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Else.tpl.php
     */
    class class_55654f0db518414907f78793b7d027601d43ad01 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "else {\n";
            crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $token[1]), $this->context);
            echo "}\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Yield.tpl.php
     */
    class class_a7fd4ba6aa8322c865f773ab9961440df3ccad7e extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "\$this->do_yield(" . ($token[1]) . ");\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Include.tpl.php
     */
    class class_6ab34a3d879c7067d4dc67f5af3a8dd380cd3156 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo $namespace . "\\Templates::exec(" . ($token[1]) . ", \$this->context);\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Echo.tpl.php
     */
    class class_1708ebe9d99ba4e58c0ae7fffeacd2f3eee56157 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "echo " . ( $token[1] ) . ";\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Foreach.tpl.php
     */
    class class_55a865e988d24c0d11ce50bc8c11519a2d28b743 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "foreach(" . ($token[1]) . ") {\n";
            crodas\SimpleView\Templates\Templates::exec('body', array('tpl' => $token[2]), $this->context);
            echo "}\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from Class.tpl.php
     */
    class class_ed71512c603ba20ba49346284ee12f19b5d744de extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "<?php\n/**\n *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)\n *  Do not edit this file.\n *\n */\n\nnamespace {\n\nclass base_template_" . ( sha1($namespace) ) . "\n{\n    protected \$parent;\n    protected \$child;\n    protected \$context;\n\n    public function yield_parent(\$name, \$args)\n    {\n        \$method = \"section_\" . sha1(\$name);\n\n        if (is_callable(array(\$this->parent, \$method))) {\n            \$this->parent->\$method(array_merge(\$this->context, \$args));\n            return true;\n        }\n\n        if (\$this->parent) {\n            return \$this->parent->yield_parent(\$name, \$args);\n        }\n\n        return false;\n    }\n\n    public function do_yield(\$name, Array \$args = array())\n    {\n        if (\$this->child) {\n            // We have a children template, we are their base\n            // so let's see if they have implemented by any change\n            // this section\n            if (\$this->child->do_yield(\$name, \$args)) {\n                // yes!\n                return true;\n            }\n        }\n\n        // Do I have this section defined?\n        \$method = \"section_\" . sha1(\$name);\n        if (is_callable(array(\$this, \$method))) {\n            // Yes!\n            \$this->\$method(array_merge(\$this->context, \$args));\n            return true;\n        }\n\n        // No :-(\n        return false;\n    }\n\n}\n\n";
            foreach($tpls as $name => $tpl) {
                echo "    /** \n     *  Template class generated from " . ( $tpl->getSource() ) . "\n     */\nclass class_" . (sha1($name)) . " extends base_template_" . ( sha1($namespace) ) . "\n{\n";
                foreach($tpl->getSections() as $name => $code) {
                    echo "    protected function section_" . (sha1($name)) . "(\$context)\n    {\n        extract(\$context);\n";
                    crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $code), $this->context);
                    echo "    }\n";
                }
                echo "\n    public function render(Array \$vars = array(), \$return = false)\n    {\n        \$this->context = \$vars;\n\n";
                if ($tpl->getParent()) {
                    echo "        \$template = " . ($namespace) . "\\Templates::get(" . ( $tpl->getParent() ) . ");\n        \$template->child = \$this;\n        \$this->parent = \$template;\n        return \$template->render(\$vars, \$return);\n\n";
                }
                else {
                    echo "        extract(\$vars);\n        if (\$return) {\n            ob_start();\n        }\n";
                    crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $tpl), $this->context);
                    echo "\n        if (\$return) {\n            return ob_get_clean();\n        }\n\n";
                }
                echo "    }\n}\n\n";
            }
            echo "}\n\nnamespace " . ($namespace) . " {\n\nclass Templates\n{\n    public static function exec(\$name, Array \$context = array(), Array \$global = array())\n    {\n        \$tpl = self::get(\$name);\n        return \$tpl->render(array_merge(\$global, \$context));\n    }\n\n    public static function get(\$name, Array \$context = array())\n    {\n        static \$classes = " . ( var_export($classes, true) ) . ";\n        \$name = strtolower(\$name);\n        if (empty(\$classes[\$name])) {\n            throw new \\RuntimeException(\"Cannot find template \$name\");\n        }\n\n        \$class = \"\\\\\" . \$classes[\$name];\n        return new \$class;\n    }\n}\n\n}\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from If.tpl.php
     */
    class class_47c00cca182fe3bc9f62a5b97ca88b8096be84f9 extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "if (" . ($token[1]) . ") {\n";
            crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $token[2]), $this->context);
            echo "} \n";
            if (!empty($token[3])) {
                crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $token[3]), $this->context);
            }

            if ($return) {
                return ob_get_clean();
            }

        }
    }

    /** 
     *  Template class generated from While.tpl.php
     */
    class class_6b1bcd97e93ed2c0cb9aac64a2ca1db0d5c1bbfd extends base_template_a7583170cd46360a631dc3d57f152bbeb4c37551
    {

        public function render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }
            echo "while (" . ($token[1]) . ") {\n";
            crodas\SimpleView\Templates\Templates::exec("body", array('tpl' => $token[2]), $this->context);
            echo "}\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

}

namespace crodas\SimpleView\Templates {

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
                'parent.tpl.php' => 'class_5d7cda60ed67317c63462a7a3f97c1eaa6a18d4e',
                'parent' => 'class_5d7cda60ed67317c63462a7a3f97c1eaa6a18d4e',
                'echox.tpl.php' => 'class_b3f21f4b7452906b330612b966219cc089b11145',
                'echox' => 'class_b3f21f4b7452906b330612b966219cc089b11145',
                'body.tpl.php' => 'class_399877791885ad1a9fde51bca4deb52107f94699',
                'body' => 'class_399877791885ad1a9fde51bca4deb52107f94699',
                'unless.tpl.php' => 'class_f5ab41dedb21a24081861ee6a36af5e59365a600',
                'unless' => 'class_f5ab41dedb21a24081861ee6a36af5e59365a600',
                'else.tpl.php' => 'class_55654f0db518414907f78793b7d027601d43ad01',
                'else' => 'class_55654f0db518414907f78793b7d027601d43ad01',
                'yield.tpl.php' => 'class_a7fd4ba6aa8322c865f773ab9961440df3ccad7e',
                'yield' => 'class_a7fd4ba6aa8322c865f773ab9961440df3ccad7e',
                'include.tpl.php' => 'class_6ab34a3d879c7067d4dc67f5af3a8dd380cd3156',
                'include' => 'class_6ab34a3d879c7067d4dc67f5af3a8dd380cd3156',
                'echo.tpl.php' => 'class_1708ebe9d99ba4e58c0ae7fffeacd2f3eee56157',
                'echo' => 'class_1708ebe9d99ba4e58c0ae7fffeacd2f3eee56157',
                'foreach.tpl.php' => 'class_55a865e988d24c0d11ce50bc8c11519a2d28b743',
                'foreach' => 'class_55a865e988d24c0d11ce50bc8c11519a2d28b743',
                'class.tpl.php' => 'class_ed71512c603ba20ba49346284ee12f19b5d744de',
                'class' => 'class_ed71512c603ba20ba49346284ee12f19b5d744de',
                'if.tpl.php' => 'class_47c00cca182fe3bc9f62a5b97ca88b8096be84f9',
                'if' => 'class_47c00cca182fe3bc9f62a5b97ca88b8096be84f9',
                'while.tpl.php' => 'class_6b1bcd97e93ed2c0cb9aac64a2ca1db0d5c1bbfd',
                'while' => 'class_6b1bcd97e93ed2c0cb9aac64a2ca1db0d5c1bbfd',
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
