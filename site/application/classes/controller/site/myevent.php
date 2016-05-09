<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_MyEvent extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $myEventObj = $this->loginUserObj->getEventObjById($id);
        if ($myEventObj) {
            $ownerObj = $myEventObj->getOwnerObj();
            $hostObj = $myEventObj->getHostObj();
            $this->template->content = View::factory('site/templates/myevent/view');
            $this->template->content->myEventObj = $myEventObj;
            $this->template->content->ownerObj = $ownerObj;
            $this->template->content->hostObj = $hostObj;
            if ($myEventObj->isTypeClass()) {
                $this->template->content->classObj = $myEventObj->getClassObj();
            }
            $this->template->content->locationObj = $locationObj;
            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'purchased';
            $this->template->content->sidebar->active = 'myevents';
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/myevent/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'purchased';
        $this->template->content->sidebar->active = 'myevents';

        $locationObjs = $this->loginUserObj->getLocationObjs();
        $friendObjs = $this->loginUserObj->getFriendObjs();

        $this->template->content->addCustomEventModal = View::factory('site/templates/myevent/modal_add');
        $this->template->content->addCustomEventModal->locationObjs = $locationObjs;
        $this->template->content->addCustomEventModal->friendObjs = $friendObjs;
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';
            $this->template = View::factory('site/templates/myevent/list_ajax');
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['owner_id'] = $this->target_user_id;

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 10;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            //$data['type'] = Model_Event::TYPE_SESSION;
            $data['status'] = Model_Event::STATUS_ACTIVE;
            if ($this->loginUserObj->isRoleHost()) {
                $myEventObjs = $this->loginUserObj->getHostedEventObjs($data,$skip,$limit);
                $total = count($this->loginUserObj->getHostedEventObjs($data));
            } else {
                $myEventObjs = $this->loginUserObj->getEventObjs($data,$skip,$limit);
                $total = count($this->loginUserObj->getEventObjs($data));
            }

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->myEventObjs = $myEventObjs;

            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
    }

    public function action_add_custom()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());

        $text = $data['text'];

        $toUserObj = Model_User::getUserObjById($data['owner_id']);
        $msgData['user_from'] = $this->loginUserObj->getId();
        $msgData['user_to'] = $toUserObj->getId();
        $msgData['date'] = date('Y-m-d H:i:s');
        $msgData['text'] = $text;

        $params = array();
        $params['action_name'] = 'Add To Cart';
        $params['action_link'] = '/cart/add_session?start='.strtotime($data['date'] . ' ' . $data['time_from']).
                    '&end='.strtotime($data['date'] . ' ' . $data['time_to']).
                    '&price='.$data['price'].
                    '&location_id='.$data['location_id'].
                    '&owner_id='.$this->loginUserObj->getId();
        $msgData['params'] = json_encode($params);
        $this->loginUserObj->addMessage($msgData);

        $this->request->redirect('/myevent/list');
    }
}
