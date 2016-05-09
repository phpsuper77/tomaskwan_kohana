<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Index extends Controller_Site_Public
{
    public $template = 'site/home2';

    public function before()
    {
        parent::before();
    }

    public function action_home() 
    {
        if ($this->loginUserObj) {
             $this->request->redirect('/dashboard');
        }

        $professionObjs = Model_Unit::getUnitObjs('profession');
        $mortarObjs = Model_Unit::getUnitObjs('mortar');

        $this->template->loginModal = View::factory('site/home2/login');
        $this->template->registerModal = View::factory('site/home2/register');
        $this->template->registerModal->professionObjs = $professionObjs;
        $this->template->registerModal->mortarObjs = $mortarObjs;
    }
}
