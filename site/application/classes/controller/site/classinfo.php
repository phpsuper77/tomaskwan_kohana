<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_ClassInfo extends Controller_Site_Public
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $classObj = Model_Class::getClassObjById($id);
        if ($classObj) {
            $userObj = $classObj->getUserObj();
            $trainerObj = $classObj->getTrainerObj();
            $locationObj = $classObj->getLocationObj();
            $pageObj = $userObj->getPageObj();
            $this->template->content = View::factory('site/templates/classinfo/view');
            $this->template->content->classObj = $classObj;
            $this->template->content->userObj = $userObj;
            $this->template->content->pageObj = $pageObj;
            $this->template->content->trainerObj = $trainerObj;
            $this->template->content->locationObj = $locationObj;
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_list()
    {
        $route = sanitizeValue($this->request->param('route'));
        $pageObj = Model_Page::getPageObjByRoute($route);
        $userObj = $pageObj->getUserObj();
        $superiorObj = $userObj->getSuperiorObj();

        $this->template->content = View::factory('site/templates/classinfo/list');

        $this->template->content->route = $this->route;

        $classObjs = $userObj->getClassObjs();

        $scheduleObjs = array();
        foreach ($classObjs as $classObj) {
            if ($classObj->isAttr('date_from')) {
                $key = date('F, Y', strtotime($classObj->getAttr('date_from')));
            } else {
                $key = date('F, Y');
            }
            if (!isset($scheduleObjs[$key]['classObjs'])) {
                $scheduleObjs[$key] = array();
                $scheduleObjs[$key]['classObjs'] = array();
            }
            $scheduleObjs[$key]['classObjs'][] = $classObj;
        }

        $this->template->content->scheduleObjs = $scheduleObjs;

        $this->template->content->owner = $pageObj->getUserId();
        $this->template->content->superiorObj = $superiorObj;
        $this->template->content->userObj = $userObj;
        $this->template->content->pageObj = $pageObj;
        $this->template->content->modelOrder = new Model_Order();

    }
}
