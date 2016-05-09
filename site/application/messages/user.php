<?php defined('SYSPATH') or die('No direct script access.');

return array(
	
	'username' => array(
					'not_empty'     => 'nazwa użytkownika nie może być pusta'),
	'email' => array(
					'not_empty'     => 'adres email nie może być pusty'),
	'password' => array(
					'not_empty'     => 'hasło nie może być puste',
					'min_length'    => 'hasło musi mieć przynajmniej :param2 znaków'),
	'password2' => array(
					'matches'     	=> 'hasła nie są zgodne'),
);
