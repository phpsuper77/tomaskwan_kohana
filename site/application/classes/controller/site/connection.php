<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Connection extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
    }

    public function action_list()
    {
        $type = sanitizeValue($this->request->param('route'));
        $this->template->content = View::factory('site/templates/connection/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'connections';
        $this->template->content->sidebar->open = 'user';
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

            $this->template = View::factory('site/templates/connection/list_ajax');
            $connObjs = $this->loginUserObj->getConnectionObjs($data, $skip, $limit);
            $total = count($this->loginUserObj->getConnectionObjs($data));

            $this->template->connObjs = $connObjs;
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


    public function action_disconnect()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->disconnectUser($id);

        Stats::track($this->loginUserObj->getId(), 'connection.disconnect', array('id'=>$id));

        //sending email if set
        $user_toObj = Model_User::getUserObjById($id);
        if($user_toObj->canNotify('email') == TRUE)
        {
            $user_from = $this->modelUser->getUserById($this->loginUserObj->getId());
            $user_to = $user_toObj;

            $body = View::factory('site/emails/template');
            $body->text = View::factory('site/emails/disconnect');
            $body->text->username = $user_from[0]['name'];
            $body->text->invitename = $user_to[0]['name'];

            sendMail('Message from Gymhit',$user_to[0]['email'],$body);
        }
        $this->request->redirect('/connection/list');
    }
}
