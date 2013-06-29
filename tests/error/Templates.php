<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */


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
        );
        $name = strtolower($name);
        if (empty($classes[$name])) {
            throw new \RuntimeException("Cannot find template $name");
        }
        $class = __NAMESPACE__ .  "\\" . $classes[$name];
        return new $class;
    }
}
