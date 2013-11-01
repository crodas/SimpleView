<?php

namespace crodas\SimpleView;

/**
 *  @Service(simple-view, {
 *      namespace: {default: NULL},
 *      views: { required: true, type: 'array_dir'},
 *      temp_dir: { default: '/tmp', type: dir} 
 *  }, {shared: true})
 */
function get_service($config)
{
    $tmp = $config['temp_dir'] . "/Templates.php";
    $env = new Environment($config['views']);
    $run = new Runtime($tmp, $env);
    if ($config['devel']) {
        $run->development();
    }
    if ($config['namespace']) {
        $run->setNamespace($config['namespace']);
    }
    return $run;
}
