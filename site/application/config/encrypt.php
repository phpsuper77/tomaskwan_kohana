<?php defined('SYSPATH') or die('No direct script access.');
// application/config/encrypt.php
 
return array(
 
    'default' => array(
        'key'    => 'VERY_SECRET_KEY_HERE_1234567890',
        'cipher' => MCRYPT_RIJNDAEL_128,
        'mode'   => MCRYPT_MODE_NOFB,
    ),
);
