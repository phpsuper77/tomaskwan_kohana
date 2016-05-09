<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Schedule extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {

        parent::before();
        if ($this->user['role'] != Model_User::ROLE_USER)
        {
            $this->request->redirect('/');
        }
    }

    public function action_index()
    {
        $this->template->content = View::factory('site/templates/schedule');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'schedule';
    }
}
