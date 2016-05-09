<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Message extends Controller_Site_Public
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

        require_once FS.'Pagination.php';

        $this->template->active = 'message';
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = 'message';	
    }

    public function action_index()
    {
        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        $route = sanitizeValue($this->request->param('route'));

        $this->template->content = View::factory('site/templates/message/index');
        $this->template->content->unchecked = count($this->modelMessage->getUncheckedMessage($this->user['id']));

        $this->template->content->newMessageModal = View::factory('site/modals/message_logged2');
        $this->template->content->newMessageModal->mode = 'new';

        /*
        if($this->loginUserObj->isRoleAdmin())
        {
            $type = 'all';
            $filter = array('type'=>$type,'id'=>$this->loginUserObj->getId());
            $this->template->content->newMessageModal->userObjs = Model_User::getUserObjs($filter);
        }
        else
        {
         */
        $type = 'connections';
        $filter = array('type'=>$type,'id'=>$this->loginUserObj->getId());
        $this->template->content->newMessageModal->userObjs = $this->loginUserObj->getConnectedUserObjs($filter);
            /*
        }
             */

    }

    public function action_list()
    {
        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        $direction = sanitizeValue($this->request->param('route'));
        if(!$direction) 
        {
            $this->request->redirect('/message/index');
        }

        $this->template = View::factory('site/templates/message/message_list_'.$direction);

        if(isset($_POST['command']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            if($data['command'] == 'delete')
            {
                foreach($data['checks'] as $check)
                {
                    if($direction == 'trash')
                    {
                        $this->loginUserObj->deleteMessage($check);	
                    }
                    else
                    {
                        $this->loginUserObj->trashMessage($check,'1');
                    }
                }
            }

            if($data['command'] == 'read')
            {
                foreach($data['checks'] as $check)
                {
                    $this->loginUserObj->checkMessage($check);	
                }				
            }
        }


        if($direction == 'trash')
        {
            $trash = '1';
        }
        else
        {
            $trash = '0';	
        }

        $page = sanitizeValue($this->request->param('param'));

        // define pagination variables
        if (!$page) $page = 1;
        $perPage = 10;
        $skip = ($page - 1) * $perPage;	
        $limit = $perPage;

        $messageObjs = $this->loginUserObj->getMessageObjs($trash, $direction, $skip, $limit);
        $total = count($this->loginUserObj->getMessageObjs($trash, $direction));

        // paginatior object
        $paginator = new Pagination('message/index/'.$direction, $total, count($messageObjs));
        $paginator->perPage = $perPage;

        $this->template->messageObjs = $messageObjs;
        $this->template->direction = $direction;
        $this->template->pages = $paginator->getPages($page);
    }

    public function action_view()
    {
        if(isset($_POST['message_id']))
        {
            $this->template = View::factory('site/templates/message/message_view');

            $this->loginUserObj->checkMessage($_POST['message_id']);

            $messageObj = $this->loginUserObj->getMessageObjById($_POST['message_id']);
            $this->template->messageObj = $messageObj;
            $this->template->fromUserObj = Model_User::getUserObjById($messageObj->getAttr('user_from'));
            $this->template->toUserObj = Model_User::getUserObjById($messageObj->getAttr('user_to'));

            $this->template->modal = View::factory('site/modals/message_logged');
            $userReplyObj = Model_User::getUserObjById($messageObj->getAttr('user_from'));
/*
            $pageObj = $this->loginUserObj->getPageObjByRoute($userReplyObj->getAttr('route'));
            $this->template->modal->pageObj = $pageObj;
 */
            $this->template->modal->userObj = $userReplyObj;
        }
        else
        {
            $this->request->redirect('/message/index');
        }
    }

    public function action_send()
    {
        if (isset($_POST['submit'])) 
        {        				
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_from'] = $this->loginUserObj->getId();
            $data['date'] = date('Y-m-d H:i:s');
            $data['text'] = $data['text'];

            if (isset($data['user_to'])) 
            {
                $data['user_arr'] = array($data['user_to']);
            }

            foreach($data['user_arr'] as $data['user_to'])
            {
                $this->loginUserObj->addMessage($data);

                Stats::track($this->loginUserObj->getId(), "msg.send", array('to'=>$data['user_to']));

                //sending email if set
                if($this->loginUserObj->canNotify($data['user_to'],'email'))
                {
                    $user_fromObj = Model_User::getUserObjById($data['user_from']);
                    $user_toObj = Model_User::getUserObjById($data['user_to']);

                    $body = View::factory('site/emails/template');
                    $body->text = View::factory('site/emails/direct');
                    $body->text->username = $user_fromObj->getName();
                    $body->text->route = $user_fromObj->getRoute();
                    $body->text->message = $data['text'];

                    Stats::track($this->loginUserObj->getId(), "notify.email", array('to'=>$data['user_to']));
                    sendMail('Message from Gymhit',$user_toObj->getEmail(),$body);

                }

                //sending sms if set
                if($this->loginUserObj->canNotify($data['user_to'],'sms'))
                {
                    $user_fromObj = Model_User::getUserObjById($data['user_from']);
                    $user_toObj = Model_User::getUserObjById($data['user_to']);

                    $body = View::factory('site/sms/direct');
                    $body->username = $user_fromObj->getName();
                    $body->message = $data['text'];

                    Stats::track($this->loginUserObj->getId(), "notify.sms", array('to'=>$data['user_to']));
                    sendSMS($user_toObj->getPhone(),$body);

                }
            }

            $this->template = View::factory('site/templates/message/success');
        }
        else
        {
            $this->request->redirect('/message/index');
        }
    }	
}
