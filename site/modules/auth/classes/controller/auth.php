<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller {
  public function action_index() {
    $data = NULL;
	
	//admin
	 if (Auth::instance()->logged_in_user() == FALSE) {
      Auth::instance()->login('email', 'password');
      if (Auth::instance()->logged_in_user()) {
        $data = Debug::vars(Auth::instance()->get_user());
      }
      else {
        $data = HTML::anchor('/auth/register/', 'Register');
      }
    }
    else {
      // Show user data
      $data = Debug::vars(Auth::instance()->get_user());

      // Logout user
      Auth::instance()->logout_user();
    }

    $this->response->body($data);
  }
}