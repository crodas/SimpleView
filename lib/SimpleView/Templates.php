<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */

namespace crodas\SimpleView\Templates;

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

    public function yield($name, Array $args = array())
    {
        if ($this->child) {
            // We have a children template, we are their base
            // so let's see if they have implemented by any change
            // this section
            if ($this->child->yield($name, $args)) {
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
 *  Template class generated from lib/SimpleView/Templates/Parent.tpl.php
 */
class class_a69a1a0ac95456ee12de32069bd521b298408844 extends base_template
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
 *  Template class generated from lib/SimpleView/Templates/Echox.tpl.php
 */
class class_c685149e8b111aceac9ab5ae3e70fe7f4c2c1dca extends base_template
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
 *  Template class generated from lib/SimpleView/Templates/Body.tpl.php
 */
class class_6163557841b4d70e97d7b52c2927f643d50ce258 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        foreach($tpl->getStmts() as $token) {
            Templates::exec($token[0], array('token' => $token ), $this->context);
        }

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from lib/SimpleView/Templates/Else.tpl.php
 */
class class_b4b3b7fc57bfb78002221cfb0413323adb00d86d extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "else {\n";
        Templates::exec("body", array('tpl' => $token[1]), $this->context);
        echo "}\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from lib/SimpleView/Templates/Yield.tpl.php
 */
class class_6fc1db63cd6fae8c0846154c6ebb03e994b41da1 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "\$this->yield(" . ($token[1]) . ");\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from lib/SimpleView/Templates/Include.tpl.php
 */
class class_9d3713d49d4c57c19c70ee7cf4ff51e553f0aef1 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "Templates::exec(" . ($token[1]) . ", \$this->context);\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from lib/SimpleView/Templates/Echo.tpl.php
 */
class class_00d86be24b3cb646a3c8469ae06ef4dba726ebd8 extends base_template
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
 *  Template class generated from lib/SimpleView/Templates/Foreach.tpl.php
 */
class class_75752c9f08a748ac7a47bfda78f25d350f4cfd46 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "foreach(" . ($token[1]) . ") {\n";
        Templates::exec('body', array('tpl' => $token[2]), $this->context);
        echo "}\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from lib/SimpleView/Templates/Class.tpl.php
 */
class class_70347e2b6cb6d007490afc615d0eebf65328f7b2 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "<?php\n/**\n *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)\n *  Do not edit this file.\n *\n */\n\n";
        if (!empty($namespace)) {
            echo "namespace " . ($namespace) . ";\n";
        }
        echo "\nclass base_template\n{\n    protected \$parent;\n    protected \$child;\n    protected \$context;\n\n    public function yield_parent(\$name, \$args)\n    {\n        \$method = \"section_\" . sha1(\$name);\n\n        if (is_callable(array(\$this->parent, \$method))) {\n            \$this->parent->\$method(array_merge(\$this->context, \$args));\n            return true;\n        }\n\n        if (\$this->parent) {\n            return \$this->parent->yield_parent(\$name, \$args);\n        }\n\n        return false;\n    }\n\n    public function yield(\$name, Array \$args = array())\n    {\n        if (\$this->child) {\n            // We have a children template, we are their base\n            // so let's see if they have implemented by any change\n            // this section\n            if (\$this->child->yield(\$name, \$args)) {\n                // yes!\n                return true;\n            }\n        }\n\n        // Do I have this section defined?\n        \$method = \"section_\" . sha1(\$name);\n        if (is_callable(array(\$this, \$method))) {\n            // Yes!\n            \$this->\$method(array_merge(\$this->context, \$args));\n            return true;\n        }\n\n        // No :-(\n        return false;\n    }\n\n}\n\n";
        foreach($tpls as $name => $tpl) {
            echo "/** \n *  Template class generated from " . ( $tpl->getSource() ) . "\n */\nclass class_" . (sha1($name)) . " extends base_template\n{\n";
            foreach($tpl->getSections() as $name => $code) {
                echo "    protected function section_" . (sha1($name)) . "(\$context)\n    {\n        extract(\$context);\n";
                Templates::exec("body", array('tpl' => $code), $this->context);
                echo "    }\n";
            }
            echo "\n    public function render(Array \$vars = array(), \$return = false)\n    {\n        \$this->context = \$vars;\n\n";
            if ($tpl->getParent()) {
                echo "        \$template = Templates::get(" . ( $tpl->getParent() ) . ");\n        \$template->child = \$this;\n        \$this->parent = \$template;\n        return \$template->render(\$vars, \$return);\n\n";
            }
            else {
                echo "        extract(\$vars);\n        if (\$return) {\n            ob_start();\n        }\n";
                Templates::exec("body", array('tpl' => $tpl), $this->context);
                echo "\n        if (\$return) {\n            return ob_get_clean();\n        }\n\n";
            }
            echo "    }\n}\n\n";
        }
        echo "\nclass Templates\n{\n    public static function exec(\$name, Array \$context = array(), Array \$global = array())\n    {\n        \$tpl = self::get(\$name);\n        return \$tpl->render(array_merge(\$global, \$context));\n    }\n\n    public static function get(\$name, Array \$context = array())\n    {\n        static \$classes = " . ( var_export($classes, true) ) . ";\n        \$name = strtolower(\$name);\n        if (empty(\$classes[\$name])) {\n            throw new \\RuntimeException(\"Cannot find template \$name\");\n        }\n        \$class = __NAMESPACE__ .  \"\\\\\" . \$classes[\$name];\n        return new \$class;\n    }\n}\n";

        if ($return) {
            return ob_get_clean();
        }

    }
}

/** 
 *  Template class generated from lib/SimpleView/Templates/If.tpl.php
 */
class class_42ea18c2eba9076d0d0c9cc19c44740e4cbb8759 extends base_template
{

    public function render(Array $vars = array(), $return = false)
    {
        $this->context = $vars;

        extract($vars);
        if ($return) {
            ob_start();
        }
        echo "if (" . ($token[1]) . ") {\n";
        Templates::exec("body", array('tpl' => $token[2]), $this->context);
        echo "} \n";
        if (!empty($token[3])) {
            Templates::exec("body", array('tpl' => $token[3]), $this->context);
        }

        if ($return) {
            return ob_get_clean();
        }

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
            'parent.tpl.php' => 'class_a69a1a0ac95456ee12de32069bd521b298408844',
            'parent' => 'class_a69a1a0ac95456ee12de32069bd521b298408844',
            'lib/simpleview/templates/parent.tpl.php' => 'class_a69a1a0ac95456ee12de32069bd521b298408844',
            'echox.tpl.php' => 'class_c685149e8b111aceac9ab5ae3e70fe7f4c2c1dca',
            'echox' => 'class_c685149e8b111aceac9ab5ae3e70fe7f4c2c1dca',
            'lib/simpleview/templates/echox.tpl.php' => 'class_c685149e8b111aceac9ab5ae3e70fe7f4c2c1dca',
            'body.tpl.php' => 'class_6163557841b4d70e97d7b52c2927f643d50ce258',
            'body' => 'class_6163557841b4d70e97d7b52c2927f643d50ce258',
            'lib/simpleview/templates/body.tpl.php' => 'class_6163557841b4d70e97d7b52c2927f643d50ce258',
            'else.tpl.php' => 'class_b4b3b7fc57bfb78002221cfb0413323adb00d86d',
            'else' => 'class_b4b3b7fc57bfb78002221cfb0413323adb00d86d',
            'lib/simpleview/templates/else.tpl.php' => 'class_b4b3b7fc57bfb78002221cfb0413323adb00d86d',
            'yield.tpl.php' => 'class_6fc1db63cd6fae8c0846154c6ebb03e994b41da1',
            'yield' => 'class_6fc1db63cd6fae8c0846154c6ebb03e994b41da1',
            'lib/simpleview/templates/yield.tpl.php' => 'class_6fc1db63cd6fae8c0846154c6ebb03e994b41da1',
            'include.tpl.php' => 'class_9d3713d49d4c57c19c70ee7cf4ff51e553f0aef1',
            'include' => 'class_9d3713d49d4c57c19c70ee7cf4ff51e553f0aef1',
            'lib/simpleview/templates/include.tpl.php' => 'class_9d3713d49d4c57c19c70ee7cf4ff51e553f0aef1',
            'echo.tpl.php' => 'class_00d86be24b3cb646a3c8469ae06ef4dba726ebd8',
            'echo' => 'class_00d86be24b3cb646a3c8469ae06ef4dba726ebd8',
            'lib/simpleview/templates/echo.tpl.php' => 'class_00d86be24b3cb646a3c8469ae06ef4dba726ebd8',
            'foreach.tpl.php' => 'class_75752c9f08a748ac7a47bfda78f25d350f4cfd46',
            'foreach' => 'class_75752c9f08a748ac7a47bfda78f25d350f4cfd46',
            'lib/simpleview/templates/foreach.tpl.php' => 'class_75752c9f08a748ac7a47bfda78f25d350f4cfd46',
            'class.tpl.php' => 'class_70347e2b6cb6d007490afc615d0eebf65328f7b2',
            'class' => 'class_70347e2b6cb6d007490afc615d0eebf65328f7b2',
            'lib/simpleview/templates/class.tpl.php' => 'class_70347e2b6cb6d007490afc615d0eebf65328f7b2',
            'if.tpl.php' => 'class_42ea18c2eba9076d0d0c9cc19c44740e4cbb8759',
            'if' => 'class_42ea18c2eba9076d0d0c9cc19c44740e4cbb8759',
            'lib/simpleview/templates/if.tpl.php' => 'class_42ea18c2eba9076d0d0c9cc19c44740e4cbb8759',
        );
        $name = strtolower($name);
        if (empty($classes[$name])) {
            throw new \RuntimeException("Cannot find template $name");
        }
        $class = __NAMESPACE__ .  "\\" . $classes[$name];
        return new $class;
    }
}
