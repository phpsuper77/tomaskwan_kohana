<?php defined('SYSPATH') or die('No direct script access.');

return array(
	
	'name' => array(
					'not_empty'     => 'nazwa członka zespołu nie może być pusta'),
	'note' => array(
					'not_empty'     => 'notka nie może być pusta'),
	'email' => array(
					'not_empty'     => 'email nie może być pusty',
					'email'         => 'niewłaściwy format adresu email')
);
