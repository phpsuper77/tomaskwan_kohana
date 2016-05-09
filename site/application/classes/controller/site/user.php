<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_User extends Controller_Site_Public
{
    public $template = 'site/index';	

    public function action_list_invites()
    {
        //check if user is logged
        if (Auth::instance()->logged_in_user() == NULL)
        {
            $this->request->redirect('/');
        }

        $type = sanitizeValue($this->request->param('route'));
        if($type == 'all' && $this->user['role'] != Model_User::ROLE_ADMIN)
        {
            $this->request->redirect('/dashboard');
        }
        if($type == 'reviews')
        {
            $this->template->content = View::factory('site/templates/review_list');
            $this->template->content->reviewModal = View::factory('site/modals/review');
        }
        else
        {
            $this->template->content = View::factory('site/templates/user_list');	
        }
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = $type;
        $this->template->sidebar->open = 'user';

        $title = $type;
        if($type == 'connections' && $this->user['role'] == Model_user::ROLE_BUSINESS)
        {
            $title = 'members';
        }
        if($type == 'all')
        {
            $title = 'all users';
            $clubs = $this->modelUser->getCount(1);
            $trainers = $this->modelUser->getCount(2);
            $users = $this->modelUser->getCount(4);
            $other = $this->modelUser->getCount(3);

            $this->template->content->users = $users[0]['rows'];
            $this->template->content->clubs = $clubs[0]['rows']+$other[0]['rows'];
            $this->template->content->trainers = $trainers[0]['rows'];
            $this->template->content->all = $trainers[0]['rows']+$users[0]['rows']+$clubs[0]['rows']+$other[0]['rows'];
        }
        $this->template->content->type = $type;
        $this->template->content->title = $title;
    }

    public function action_list()
    {
        //check if user is logged
        if (Auth::instance()->logged_in_user() == NULL)
        {
            $this->request->redirect('/');
        }

        $type = sanitizeValue($this->request->param('route'));
        if($type == 'all' && $this->user['role'] != Model_User::ROLE_ADMIN)
        {
            $this->request->redirect('/dashboard');
        }
        if($type == 'reviews')
        {
            $this->template->content = View::factory('site/templates/review_list');
            $this->template->content->reviewModal = View::factory('site/modals/review');
        }
        else
        {
            $this->template->content = View::factory('site/templates/user_list');	
        }
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = $type;
        $this->template->sidebar->open = 'user';

        $title = $type;
        if($type == 'connections' && $this->user['role'] == Model_user::ROLE_BUSINESS)
        {
            $title = 'members';
        }
        if($type == 'all')
        {
            $title = 'all users';
            $clubs = $this->modelUser->getCount(1);
            $trainers = $this->modelUser->getCount(2);
            $users = $this->modelUser->getCount(4);
            $other = $this->modelUser->getCount(3);

            $this->template->content->users = $users[0]['rows'];
            $this->template->content->clubs = $clubs[0]['rows']+$other[0]['rows'];
            $this->template->content->trainers = $trainers[0]['rows'];
            $this->template->content->all = $trainers[0]['rows']+$users[0]['rows']+$clubs[0]['rows']+$other[0]['rows'];
        }
        $this->template->content->type = $type;
        $this->template->content->title = $title;
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['type'] = sanitizeValue($this->request->param('route'));
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

            if($data['type'] == 'reviews')
            {
                $this->template = View::factory('ajax/review_list');
                $guserObjs = Model_Review::getReviewObjs($data,$skip,$limit);
                $total = count(Model_Review::getReviewObjs($data));
            }
            else
            {
                $this->template = View::factory('ajax/user_list');
                if($param == 'dashboard')
                {
                    $guserObjs = Model_User::getUserObjs($data);
                    $this->template->mode = 'dashboard';
                }
                else
                {					
                    $guserObjs = Model_User::getUserObjs($data, $skip, $limit);
                    $total = count(Model_User::getUserObjs($data));
                }
            }

            $this->template->guserObjs = $guserObjs;
            $this->template->type = $data['type'];

            if($param != 'dashboard')
            {
                // paginatior object
                $paginator = new Pagination('', $total);
                $paginator->perPage = $perPage;

                if($total > $perPage)
                    $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
        {
            $this->request->redirect('/');	
        }
    }

/*
    public function action_list_filter()
    {
        if(isset($_POST['send']))
        {

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            if(Auth::instance()->logged_in_user())
                $data['id'] = $this->loginUserObj->getId();

            $data['role'] = Model_User::ROLE_USER;

            $this->template = View::factory('ajax/user_filter');

            $this->template->users = $this->modelUser->getUsersFilter($data);
        }
        else
            $this->request->redirect('/');	
    }
*/

    public function action_invite()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_invite'] = $this->loginUserObj->getId();
            $data['date'] = date('Y-m-d H:i:s');
            $data['invitation'] = 0;

            $this->loginUserObj->inviteUser($data);

            $this->template = View::factory('ajax/blank');

            //sending email if set
            $user_toObj = Model_User::getUserObjById($data['user_id']);
            if($user_toObj->canNotify('email') == TRUE)
            {
                $user_fromObj = $this->loginUserObj;

                $body = View::factory('site/emails/template');
                $body->text = View::factory('site/emails/invitation');
                $body->text->username = $user_fromObj->getName();
                $body->text->invitename = $user_toObj->getName();

                sendMail('Message from Gymhit',$user_toObj->getEmail(),$body);

            }
        }		
    }

    public function action_connect()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_id'] = $this->user['id'];		
            $this->loginUserObj->connectUser($data);
            $this->template = View::factory('ajax/blank');

        }		
    }

    public function action_disconnect()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_invite'] = $this->loginUserObj->getId();		
            $this->loginUserObj->disconnectUser($data['user_id']);

            $this->template = View::factory('ajax/blank');

            //sending email if set
            $user_toObj = Model_User::getUserObjById($data['user_id']);
            if($user_toObj->canNotify('email') == TRUE)
            {
                $user_from = $this->modelUser->getUserById($this->loginUserObj->getId());
                $user_to = $this->modelUser->getUserById($data['user_id']);

                $body = View::factory('site/emails/template');
                $body->text = View::factory('site/emails/disconnect');
                $body->text->username = $user_from[0]['name'];
                $body->text->invitename = $user_to[0]['name'];

                sendMail('Message from Gymhit',$user_to[0]['email'],$body);	
            }			
        }		
    }

}
