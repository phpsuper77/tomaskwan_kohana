<?php

class Fb {

	public static function getFb() 
	{
		require_once __DIR__ . '/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php';
		$fb = new Facebook\Facebook([
				'app_id' => Kohana::$config->load('site.fb.app-id'),
				'app_secret' => Kohana::$config->load('site.fb.app-secret'),
				'default_graph_version' => 'v2.2',
				]);
		return $fb;
	}

}
?>	
