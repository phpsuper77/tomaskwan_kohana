<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Invite extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/invite/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'invitations';
        $this->template->content->sidebar->open = 'user';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['type'] = 'invitations';
            $data['id'] = $this->loginUserObj->getId();

            $param = sanitizeValue($this->request->param('param'));

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

            $this->template = View::factory('site/templates/invite/list_ajax');
            $inviteObjs = $this->loginUserObj->getInviteObjs($data, $skip, $limit);
            $total = count($this->loginUserObj->getInviteObjs($data));

            $this->template->inviteObjs = $inviteObjs;
            $this->template->type = $data['type'];

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_connect()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->connectUser($id);
        Stats::track($this->loginUserObj->getId(), 'invite.connect', array('id'=>$id));
        $this->request->redirect('/connection/list');
    }

    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteInvite($id);
        Stats::track($this->loginUserObj->getId(), 'invite.delete', array('id'=>$id));
        $this->request->redirect('/invite/list');
    }
}
