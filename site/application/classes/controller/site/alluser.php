<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_AllUser extends Controller_Site_Private
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
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        $type = sanitizeValue($this->request->param('route'));
        $this->template->content = View::factory('site/templates/alluser/list');	
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = 'user';
        $this->template->sidebar->open = 'admin';

        $title = $type;
        $title = 'all users';

        $clubCount = Model_User::getCountByRole(Model_User::ROLE_BUSINESS);
        $trainerCount = Model_User::getCountByRole(Model_User::ROLE_TRAINER);
        $userCount = Model_User::getCountByRole(Model_User::ROLE_USER);
        $schoolCount = Model_User::getCountByRole(Model_User::ROLE_SCHOOL);

        if (!$data['order']) {
            $data['order'] = 'desc';
        }
        $this->template->content->filter = $data;
        $this->template->content->users = $userCount;
        $this->template->content->clubs = $clubCount;
        $this->template->content->trainers = $trainerCount;
        $this->template->content->all = $clubCount + $trainerCount + $userCount + $schoolCount;
        $this->template->content->type = $type;
        $this->template->content->title = $title;
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
error_log("XXX data=".print_r($data,true));
            $data['type'] = sanitizeValue($this->request->param('route'));
            $param = sanitizeValue($this->request->param('param'));
            $data['id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 20;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

/*
            $data['order'] = 'desc';
            $data['sort'] = 'id';
            $data['user'] = FALSE;
*/

            $data['all'] = true; // including enabled = 0
            $this->template = View::factory('site/templates/alluser/list_ajax');
            $guserObjs = Model_User::getUserObjs($data, $skip, $limit);
            $total = Model_User::getUserObjsCount($data);

            $this->template->guserObjs = $guserObjs;
            $this->template->filter = $data;
            $this->template->type = $data['type'];

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        } else {
           $this->request->redirect('/alluser/list');
        }
    }

    public function action_user_activate()
    {
        $user_id = sanitizeValue($this->request->param('route'));
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());
        $this->loginUserObj->activateUser($user_id,1);
        $this->request->redirect('/alluser/list?sort='.$data['sort'].'&page='.$data['page'].'&order='.$data['order'].'&role='.$data['role'].'&enabled='.$data['enabled']);
    }

    public function action_user_deactivate()
    {
        $user_id = sanitizeValue($this->request->param('route'));
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());
        $this->loginUserObj->activateUser($user_id,0);
        $this->request->redirect('/alluser/list?sort='.$data['sort'].'&page='.$data['page'].'&order='.$data['order'].'&role='.$data['role'].'&enabled='.$data['enabled']);
    }
}
