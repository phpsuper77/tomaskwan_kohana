<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'native' => array(
        'name' => 'session_name',
        'lifetime' => DATE::WEEK,
    ),	
	/*'database' => array(
        'group' => 'default',
        'table' => 'sessions',
        'gc' => 500,

        'name' => 'database',
        'lifetime' => DATE::WEEK,

        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),

    ),*/
);