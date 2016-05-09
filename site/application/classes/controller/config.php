<?php 
defined('SYSPATH') or die('No direct script access.');
 
class Controller_Config extends Controller_Template
{	
	public function before()
	{
		parent::before();
		   
		$this->config = Kohana::$config->load('config');
		$this->session = Session::instance();
		
		//main project path
		if(!defined("PATH")) define("PATH", Url::base());
		if(!defined("FULLPATH")) define("FULLPATH", "http://".$_SERVER["HTTP_HOST"]);

		// system resources path - js, css, images, ckeditor, functions
		if(!defined("R")) define("R", Url::base()."resources/");
		if(!defined("JS")) define("JS", Url::base()."resources/js/");
		if(!defined("MJS")) define("MJS", Url::base()."resources/metronic/js/");
		//if(!defined("CONTR")) define("CONTR",Url::base(TRUE,TRUE)."aplication/classes/controler/");
		if(!defined("CSS")) define("CSS", Url::base()."resources/css/");
		if(!defined("MCSS")) define("MCSS", Url::base()."resources/metronic/css/");
		if(!defined("IMG")) define("IMG", Url::base()."resources/images/");
		if(!defined("MIMG")) define("MIMG", Url::base()."resources/metronic/img/");
		if(!defined("FS")) define("FS", "resources/functions/");
		if(!defined("UPU")) define("UPU", Url::base()."resources/upload/users/");
		
		//functions	
//		require_once(__DIR__.'functions.php');		
			
		parent::after();
		
		$this->auth = Auth::instance();
				
		$this->user = $this->auth->get_user();

		// package logged in user as a Model_User object
		$this->loginUserObj = Model_User::getUserObjById($this->user['id']);
		if ($this->loginUserObj) {
			View::bind_global('loginUserObj', $this->loginUserObj);
		}

		View::bind_global('auth', $this->auth);
		View::bind_global('user', $this->user);
	}
}
?>
