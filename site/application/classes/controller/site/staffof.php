<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_StaffOf extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
    }

    public function action_setting()
    {
        $id = sanitizeValue($this->request->param('route'));
        $ownerObj = Model_User::getUserObjById($id);

        $data = Arr::map('sanitizeHTMLValue', $this->request->post());

        if (!isset($data['enabled'])) {
            $data['enabled'] = 0;
        } 

        $this->loginUserObj->updateStaffSetting($data);
        if(count($data['check'])>0) {
            $this->loginUserObj->deleteStaffSettingTime($ownerObj->getId());
            foreach($data['check'] as $day => $value) {
                $this->loginUserObj->addStaffSettingTime($ownerObj->getId(),$day,date('H:i:s',strtotime($data['time_from'][$day])),date('H:i:s',strtotime($data['time_to'][$day])),$data['time_custom'][$day]);
            }
        }

        $this->request->redirect('/staffof/availability/'.$id);
    }

    public function action_availability()
    {
        $id = sanitizeValue($this->request->param('route'));
        $hostObj = Model_User::getUserObjById($id);
        $staffSettingObj = $this->loginUserObj->getStaffSettingObj($hostObj->getId());
        $this->template->content = View::factory('site/templates/staffof/availability');
        $this->template->content->hostObj = $hostObj;
        $this->template->content->staffSettingObj = $staffSettingObj;
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'business';
        $this->template->content->sidebar->active = 'staffof';
    }

    public function action_list()
    {
        $type = sanitizeValue($this->request->param('route'));
        $this->template->content = View::factory('site/templates/staffof/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'business';
        $this->template->content->sidebar->active = 'staffof';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['type'] = 'connections';
            $param = sanitizeValue($this->request->param('param'));
            $data['id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

            if($this->user['role'] == Model_User::ROLE_USER)
            {
                $data['user'] = TRUE;
            }
            else
            {
                $data['user'] = FALSE;
            }

            $staffObjs = $this->loginUserObj->getStaffOfObjs($data, $skip, $limit);
            $total = count($this->loginUserObj->getStaffOfObjs($data));

            $this->template = View::factory('site/templates/staffof/list_ajax');
            $this->template->staffObjs = $staffObjs;
            $this->template->type = $data['type'];

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            if($total > $perPage)
                $this->template->pages = $paginator->getPages($data['page']);
        }
        else
        {
            $this->request->redirect('/');
        }
    }

}
