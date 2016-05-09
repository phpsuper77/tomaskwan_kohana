<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Error extends Controller_Site_Public
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_404()
    {
        $this->template->content = View::factory('site/templates/error');
        $this->template->content->error = __("OPS! THE REQUESTED PAGE IS NOT PRESENT");
    }

    public function action_default()
    {
        $this->template->content = View::factory('site/templates/error');
        $this->template->content->error = __("HMM, SOMETHING WRONG WITH THIS REQUEST");
    }
}
