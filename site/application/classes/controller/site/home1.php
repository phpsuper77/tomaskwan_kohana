<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Home1 extends Controller_Site_Public
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
    }

    public function action_index() 
    {
        $this->template->content = View::factory('site/templates/home');
        $this->template->content->boxes = View::factory('site/boxes');
        $this->template->content->boxes->search = $this->modelSearch->getSearch();

        $professionObjs = Model_Unit::getUnitObjs('profession');
        $mortarObjs = Model_Unit::getUnitObjs('mortar');
        $this->template->content->titleObjs = array_merge($professionObjs,$mortarObjs);
        $this->template->content->cities = Model_Unit::getCityList();

        $this->template->buttons = null;
        if ($this->loginUserObj)
        {
            $this->template->userBar->toggler = ' hidden';
        }
    }
}
