<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Error extends Controller_Template {
    // if you've created your custom error template. If not use your standard template here.
    public $template = 'error';
     
    public function before() {
        parent :: before();
    }
     
    /**
     * Serves HTTP 404 error page
     */
    public function action_404() {
        $this->template->content = View :: factory('error/404');
    }
 
    /**
     * Serves HTTP 500 error page
     */
    public function action_500() {
        $this->template->content = View :: factory('error/500');
    }
}