<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Page extends Controller_Site_Public
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        $this->route = sanitizeValue($this->request->param('route'));

        //model
        $this->modelStatus = new Model_Status();	
        $this->modelClass = new Model_Class();
        $this->modelSpecoffer = new Model_Specoffer();
        $this->modelFreePass = new Model_Freepass();

    }

    public function action_index_user()
    {
        $pageObj = Model_Page::getPageObjByRoute($this->route);
        $userObj = $pageObj->getUserObj();
        $role = $userObj->getRole();
        $settingObj = $userObj->getSettingObj();

        $MAP_OBJECT = new GoogleMapAPI(); 
        $MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;
        $start = $MAP_OBJECT->getGeoCode($userObj->getAddress().' '.$userObj->getCity().', '.$userObj->getZip());

            $this->template->content = View::factory('site/templates/page/user');
            $this->template->content->units = $this->modelUnit->getUnitList('interest');
            // TOO SLOW
//            $this->template->content->news = $this->modelUser->getNetworkNews($pageObj->getUserId());

            $i = 0;			
            $friendObjs = $userObj->getFriendObjs();
            foreach($friendObjs as $friendObj)
            {
                $possibleFriendObjs = $friendObj->getFriendObjs();
                foreach($possibleFriendObjs as $possibleFriendObj)
                {
                    if($possibleFriendObj->getId() != $userObj->getId()) 
                    {
                        $discovers[$i]['id'] = $possibleFriendObj->getId();
                        $discovers[$i]['name'] = $possibleFriendObj->getAttr('name');
                        $discovers[$i]['route'] = $possibleFriendObj->getAttr('route');
                        $discovers[$i]['avatar'] = $possibleFriendObj->getAttr('avatar');
                        $discovers[$i]['title'] = $possibleFriendObj->getAttr('title');
                        $discovers[$i]['distance'] = getGeoDistance($start['lat'],$start['lon'],$possibleFriendObj->getLat(),$possibleFriendObj->getLon());
                    }
                }
            }

            //distance sort
            if(count($discovers) > 0)
            {
                foreach($discovers as $key => $value)
                {
                    $dist[$key]  = $value['distance'];
                }
                array_multisort($dist, SORT_ASC, $discovers);
            }
            $this->template->content->discovers = $discovers;

            //check connect
            $this->template->content->isConnect = false;
            $this->template->content->isInvite = false;
            if ($this->loginUserObj) {
                $this->template->content->isConnect = $this->loginUserObj->isConnected($pageObj->getUserId());
                $this->template->content->isInvite = $this->loginUserObj->isInvited($pageObj->getUserId());
            }
            $this->template->userBar->toggler = ' hidden';

            //status modal
            $this->template->content->shareStatusModal = View::factory('site/modals/share_status');
            $this->template->content->shareStatusModal->route = $this->route;

        $this->template->content->pageObj = $pageObj;
        $this->template->content->userObj = $userObj;
        $this->template->content->settingObj = $pageObj->getUserObj()->getSettingObj();

        $this->template->content->statusObjs = $userObj->getStatusObjs();
        $this->template->content->role = $role;

        //model status
        $this->template->content->modelStatus = $this->modelStatus;

        //boxes for no active
        if(!$userObj->isActive())
        {	
            $this->template->content->boxes = View::factory('site/boxes');
        }

    }

    public function action_index_facility()
    {
        $pageObj = Model_Page::getPageObjByRoute($this->route);
        $userObj = $pageObj->getUserObj();
        $settingObj = $userObj->getSettingObj();
        $role = $userObj->getRole();

            $this->template->content = View::factory('site/templates/page/facility');

            if ($this->loginUserObj)
            {
                $this->template->content->distance = getGeoDistance($start['lat'],$start['lon'],$this->loginUserObj->getLat(),$this->loginUserObj->getLon());
            }

            if($role != Model_User::ROLE_TRAINER)
            {
                $filter = array('sort'=>'id','order'=>'ASC','type'=>'staff','superior_id'=>$pageObj->getUserId());
                $this->template->content->staffObjs = $userObj->getStaffObjs($filter,0,4);
            }

            // support independent trainer
            $filter = array('sort'=>'time_from','order'=>'ASC','user_id'=>$pageObj->getUserId());
            $this->template->content->classObjs = $userObj->getClassObjs($filter);
            $this->template->content->unitObjs = Model_Unit::getUnitObjs('amenity');

            //add visit
            $this->modelPage->updatePageVisit($pageObj->getId());

            $this->template->content->imageObjs = $userObj->getImageObjs();
            $this->template->content->credentialObjs = $userObj->getCredentialObjs();
            $this->template->content->reviewObjs = $pageObj->getReviewObjs();
            $this->template->content->ratingObj = $pageObj->getRatingObj();
            //$notes = $this->modelReview->getNotes($pageObj->getUserId());
            //$this->template->content->notes = $notes[0];
            $this->template->content->modelOrder = $this->modelOrder;
            $this->template->content->modelClass = $this->modelClass;
            $this->template->content->modelSettings = $this->modelSettings;

            if ($this->loginUserObj) 
            {
                $this->template->content->checkReview = $pageObj->hasReviewFrom($this->loginUserObj);

                //check order
                $cartObj = $this->loginUserObj->getCartObj();
                if($cartObj && $cartObj->getAttr('owner_id') != $pageObj->getUserId())
                {
                    $order = 'disable';
                }
                $this->template->content->order = $order;
                $this->template->content->age = $this->loginUserObj->isGoodAge();
            }

        //modals for direct message
        if ($this->loginUserObj)
        {
            $this->template->content->freePassModal = View::factory('site/modals/free_pass');
            $this->template->content->freePassModal->pageObj = $pageObj;
            $this->template->content->freePassButton = $this->loginUserObj->checkFreePass($pageObj->getUserId());

            if($this->loginUserObj->checkTour($pageObj->getUserId()) == FALSE)
            {
                if ($this->loginUserObj->getRole() == Model_User::ROLE_USER)
                {
                }
            }
            else
            {
                $this->template->content->tour = 'disable';				
            }

            //check connect
            $this->template->content->isConnect = $this->loginUserObj->isConnected($pageObj->getUserId());
            $this->template->content->isInvite = $this->loginUserObj->isInvited($pageObj->getUserId());
            $this->template->userBar->toggler = ' hidden';

            //status modal
            $this->template->content->shareStatusModal = View::factory('site/modals/share_status');
            $this->template->content->shareStatusModal->route = $this->route;

            $data = array('switch'=>'active','owner_id'=>$pageObj->getUserId());
            $offerObjs = $userObj->getOfferObjs($data, 0, 1);
            $offerObj = false;
            if (count($offerObjs) > 0) {
                $offerObj = $offerObjs[0];
                $offerObj->setAttr('quant', $offerObj->getAttr('max') - $this->modelSpecoffer->checkQuantity($offerObj->getId()));
                if($offerObj->getAttr('date_to'))
                {
                    if(strtotime('now')>strtotime($offerObj->getAttr('date_to')))
                    {
                        $offerObj->setAttr('expire', true);	
                    }
                }
            }
            $this->template->content->offerObj = $offerObj;

            //specoffer modal
            $this->template->content->specOfferModal = View::factory('site/modals/specoffer');
            $this->template->content->specOfferModal->offerObj = $offerObj;
            $this->template->content->specOfferModal->order = $order;
            $this->template->content->specOfferModal->route = $this->route;
            $this->template->content->specOfferModal->age = $this->loginUserObj->isGoodAge();
        }

        $this->template->content->pageObj = $pageObj;
        $this->template->content->userObj = $userObj;
        $this->template->content->settingObj = $pageObj->getUserObj()->getSettingObj();

        $this->template->content->statusObjs = $userObj->getStatusObjs();
        $this->template->content->role = $role;

        //model status
        $this->template->content->modelStatus = $this->modelStatus;

        //boxes for no active
        if(!$userObj->isActive())
        {	
            $this->template->content->boxes = View::factory('site/boxes');
        }
    }

    public function action_index()
    {
        //check if user is logged
        if (!$this->route)
        {
            $this->template->content = View::factory('site/templates/error');
            $this->template->content->error = __("ERROR_NO_USERNAME_SUPPLIED");
            return;
        }

        $pageObj = Model_Page::getPageObjByRoute($this->route);
        if (!$pageObj) 
        {
            $this->template->content = View::factory('site/templates/error');
            $this->template->content->error = __("ERROR_INVALID_USERNAME");
            return;
        }

        $userObj = $pageObj->getUserObj();
        $role = $userObj->getRole();
        $settingObj = $userObj->getSettingObj();

        if (!$userObj->isActive())
        {
            $this->template->content = View::factory('site/templates/error');
            $this->template->content->error = __("ERROR_USER_IS_NOT_ACTIVE");
            return;
        }

        if (!$settingObj->isPublic())
        {
            $this->template->content = View::factory('site/templates/error');
            $this->template->content->error = __("ERROR_PAGE_IS_NOT_PUBLIC");
            return;
        }

        if ($userObj->isRoleUser()) {
            $this->action_index_user();
        } else {
            $this->action_index_facility();
        }
    }

    public function action_status()
    {
        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeValue', $this->request->post());
            if($_POST['submit'] == 'Add')
            {	
                // handle image
                $matches = array();
                $tokens = explode(",", $data['top_pic']);
                if (preg_match("/data:image\/(.*);base64/", $tokens[0], $matches))
                {
                    // add to S3
                    $path = '/tmp/__status_'.getmypid();
                    @mkdir($path);
                    $filename = time().'.'.$matches[1];
                    $file = $path . '/' . $filename;
                    $fp = fopen($file, "w+");
                    fwrite($fp, base64_decode($tokens[1]));
                    fclose($fp);
                    $s3 = Amazon::instance()->get('s3');
                    $result = $s3->putObject(array(
                        'Bucket' => Kohana::$config->load('site.s3.bucket'),
                        'Key' => Kohana::$config->load('site.s3.path')."/users/".$this->loginUserObj->getId()."/status/".$filename,
                        'Body' => fopen($file, "r"),
                        'ACL' => 'public-read',
                    ));
                    system("rm -rf $path");
                    $data['top_pic'] = $filename;
                }

                // update
                $data['user_id'] = $this->loginUserObj->getId();
                $data['date'] = date('Y-m-d H:i:s');
                $data['id'] = $this->loginUserObj->addStatus($data);
                $template_url = 'ajax/status_'.$data['side'];
                $this->template = View::factory($template_url);
                $this->template->statusObj = $this->loginUserObj->getStatusObjById($data['id']);
            }
            if($_POST['submit'] == 'Save')
            {
                $this->loginUserObj->updateStatus($data);
                $this->template = View::factory('ajax/blank');
            }
        }
        else
        {
            $this->request->redirect('/page/index/'.$this->route);
        }

    }

    public function action_share_status()
    {
        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['user_id'] = $this->loginUserObj->getId();
            $data['date'] = date('Y-m-d H:i:s');
            $data['id'] = $this->loginUserObj->addStatus($data);
            $this->loginUserObj->updateStatusShare($data['id']);
            $this->request->redirect('/page/index/'.$this->loginUserObj->getRoute());

        }
        else
        {
            $this->request->redirect('/page/index/'.$this->route);
        }

    }

    public function action_delete_status()
    {

        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $this->loginUserObj->deleteStatus($data['id']);
            $this->template = View::factory('ajax/blank');
        }
        else
        {
            $this->request->redirect('/page/index/'.$this->route);
        }
    }

    public function action_comment()
    {

        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_id'] = $this->loginUserObj->getId();
            $data['date'] = date('Y-m-d H:i:s');
            $data['id'] = $this->loginUserObj->addComment($data);
            $template_url = 'ajax/comment_'.$data['side'];
            $this->template = View::factory($template_url);

            $data['avatar'] = $this->loginUserObj->getAttr('avatar');
            $data['name'] = $this->loginUserObj->getName();
            $this->template->commentObj = $this->loginUserObj->getCommentObjById($data['id']);
        }
        else
        {
            $this->request->redirect('/page/index/'.$this->route);
        }
    }

    public function action_like()
    {
        //check if user is logged
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_id'] = $this->loginUserObj->getId();
            $data['date'] = date('Y-m-d H:i:s');
            $this->loginUserObj->addLike($data);
            $this->template = View::factory('ajax/blank');	
        }
        else
        {
            $this->request->redirect('/page/index/'.$this->route);
        }
    }

    public function action_review()
    {
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['user_id'] = $this->loginUserObj->getId();
            $data['date'] = date('Y-m-d H:i:s');
            $userObj = Model_User::getUserObjById($data['user_id']);
            $data['name'] = $userObj->getName();
            $data['avatar'] = $userObj->getAttr('avatar');
            $this->loginUserObj->addReview($data);

            $this->template = View::factory('ajax/review');
            $this->template->review = $data;	
        }
        else
            $this->request->redirect('/page/index/'.$this->route);
    }

    public function action_staff()
    {
        $pageObj = Model_Page::getPageObjByRoute($this->route);
        $userObj = $pageObj->getUserObj();
        if($userObj->isRoleTrainer()) {
            $this->request->redirect('/page/'.$this->route);
        }

        $this->template->content = View::factory('site/templates/page/our_staff');

        $filter = array('sort'=>'id','order'=>'ASC','type'=>'staff','superior_id'=>$page[0]['id']);
        $this->template->content->staffObjs = $userObj->getStaffObjs($filter);

        $this->template->content->route = $this->route;

        $this->template->content->modelOrder = $this->modelOrder;
        $this->template->content->modelClass = $this->modelClass;
        $this->template->content->modelSettings = $this->modelSettings;

        //check order
        $orderObjs = array();
        if ($this->loginUserObj)
        {
            $cartObj = $this->loginUserObj->getCartObj();
            $this->template->content->age = $this->loginUserObj->isGoodAge();
        }
        if($orderObj && $cartObj->getAttr('owner_id') != $pageObj->getAttr('id'))
        {
            $this->template->content->order = 'disable';
        }


    }

}
