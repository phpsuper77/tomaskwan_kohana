<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Unit extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/unit/list');
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            if($data['submit'] == 'add')
            {
                $this->loginUserObj->addUnit($data);
                $this->template->content->successAction = 'added';

            }
            if($data['submit'] == 'edit')
            {
                $this->loginUserObj->updateUnit($data);
                $this->template->content->successAction = 'edited';

            }
            $this->template->content->type = $data['type'];
        }
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'admin';
        $this->template->content->sidebar->active = 'units';
        $this->template->content->unitModal = View::factory('site/templates/unit/modal');

        $this->template->content->interestObjs = Model_Unit::getUnitObjs('interest');
        $this->template->content->amenityObjs = Model_Unit::getUnitObjs('amenity');
        $this->template->content->professionObjs = Model_Unit::getUnitObjs('profession');
        $this->template->content->mortarObjs = Model_Unit::getUnitObjs('mortar');
        $this->template->content->schoolObjs = Model_Unit::getUnitObjs('school');
    }

    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteUnit($id);
        $this->request->redirect('/unit/list');
    }

}
