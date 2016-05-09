<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Session extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_availability()
    {
        $settingObj = $this->loginUserObj->getSettingObj();
        $this->template->content = View::factory('site/templates/session/availability');
        $this->template->content->settingObj = $settingObj;
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'availability';
    }
}
