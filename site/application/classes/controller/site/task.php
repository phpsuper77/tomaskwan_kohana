<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Task extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
        if (!$this->loginUserObj->isRoleAdmin())
        {
            $this->request->redirect('/');
        }
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/task/list');
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = 'task';
        $this->template->sidebar->open = 'admin';
        $this->template->content->taskObjs = Model_Task::getTaskObjs(array(), 0, 20);
    }

}
