<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Staff extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
    }

    public function action_add()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $this->loginUserObj->connectStaff($data['user_id']);
        $this->request->redirect('/staff/list');
    }

    public function action_connect()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->connectStaff($data['user_id']);
        $this->request->redirect('/staff/list');
    }

    public function action_disconnect()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->disconnectStaff($id);
        $this->request->redirect('/staff/list');
    }

    public function action_list()
    {
        $type = sanitizeValue($this->request->param('route'));
        $this->template->content = View::factory('site/templates/staff/list');

        $connectedObjs = $this->loginUserObj->getStaffCandidateObjs(array(), 0, 10);
        $filtered = array();

        $this->template->content->addStaffModal = View::factory('site/templates/staff/modal_add');
        $this->template->content->addStaffModal->connectedObjs = $connectedObjs;
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'business';
        $this->template->content->sidebar->active = 'staff';
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

            $staffObjs = $this->loginUserObj->getStaffObjs($data, $skip, $limit);
            $total = count($this->loginUserObj->getStaffObjs($data));

            $this->template = View::factory('site/templates/staff/list_ajax');
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
