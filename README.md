Simple View
===========

This project is a simple template compiler which aims to be compatible with [Laravel's Blade view engine](http://four.laravel.com/docs/templates#blade-templating).

It is different though as it generates code which doesn't depent at all in this project to run, therefore it can compile templates offline once.

How to use it
-------------

The simplest way of using the compiler is by downloading the `phar` cli application.

```sh
wget https://github.com/crodas/SimpleView/raw/master/view-compiler.phar -O view-compiler
chmod +x view-compiler
```

Now you have the `view-compiler` script ready to run. It is very simple to use now:

```sh
./view-compiler compile tests/views/
```

That would generate a single file `tests/views/Templates.php` with all our templates compiled.

```php
require "tests/views/Templatas.php";

// By defualt its content will be print
Templates::get("if.tpl.php")->render(["name" => "cesar", "age" => 25]);

// but it can buffered as well
$buffer = Templates::get("if.tpl.php")->render(["name" => "cesar", "age" => 25], true);
echo $buffer;
```

You can optionally give a namespace to the generate template file to avoid class name conflicts

```sh
./view-compiler compile tests/views/ -N demo
```

Syntax
------

It is compatible with [Laravel's Blade view engine](http://four.laravel.com/docs/templates#blade-templating).


TODO
----
1. Better error support
2. Mode documentation
3. 
