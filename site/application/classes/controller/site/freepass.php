<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Freepass extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        //check if user is logged
        if ($this->loginUserObj->getRole() == Model_User::ROLE_ADMIN)
        {
            $this->request->redirect('/');
        }

        //model
        $this->modelFreePass = new Model_Freepass();
        if($this->loginUserObj->getAttr('superior')==NULL)
        {
            $this->target_user_id = $this->loginUserObj->getId();
        }
        else
        {
            $this->target_user_id = $this->loginUserObj->getAttr('superior');
        }
    }

    public function action_list()
    {
        if ($this->user['role'] == Model_User::ROLE_USER) 
        {
            $this->request->redirect('/');
        }
        $this->template->content = View::factory('site/templates/freepass/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'marketing';
        $this->template->content->sidebar->active = 'free_pass';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/freepass/list_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['owner_id'] = $this->target_user_id;

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $freePassObjs = $this->loginUserObj->getFreePassObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getFreePassObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->freepassObjs = $freePassObjs;

            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
            $this->request->redirect('/');	
    }

    public function action_add()
    {

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_id'] = $this->loginUserObj->getId();
            $data['code'] = $data['owner_id'].substr(md5(time()),0,7);

            $this->loginUserObj->addFreePass($data);

            $user_toObj = Model_User::getUserObjById($data['user_id']);
            $clubObj = Model_User::getUserObjById($data['owner_id']);

            $body = View::factory('site/emails/template');
            $body->text = View::factory('site/emails/free_pass');
            $body->text->username = $user_toObj->getName();
            $body->text->code = $data['code'];
            $body->text->club = $clubObj->getName();

            sendMail('Message from Gymhit',$user_to[0]['email'],$body);

            $this->template = View::factory('ajax/code');
            $this->template->code = $data['code'];

        }
        else
        {
            $this->request->redirect('/');		
        }
    }
}
