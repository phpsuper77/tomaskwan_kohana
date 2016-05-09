<?php

class Minion_Autoload {

        public static function autoload($class)
        {
		if (preg_match("/Minion/", $class)) {
			require_once(APPPATH.'classes/task/'.$class.'.php');
		}
        }
}

// Register the autoloader
spl_autoload_register(array('Minion_Autoload', 'autoload'));

Route::set('minion', 'minion(/<action>)(/<task>)', array('action' => 'help'))
	->defaults(array(
		'controller' => 'minion',
		'action'     => 'execute',
	));
