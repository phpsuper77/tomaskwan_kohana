<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
    'default' => array
    (
        'type'       => 'mysql',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'root',
            'password'   => 'root',
            'persistent' => FALSE,
            'database'   => 'gymhit',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'profiling'    => TRUE,
    ),
 
);