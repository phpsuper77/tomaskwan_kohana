<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Base extends Controller_Config
{
    public function before()
    {
        parent::before();

        if (Auth::instance()->logged_in_user())
        {
            $this->loginUserObj = Model_User::getUserObjById(Auth::instance()->get_user()['id']);
            $this->template->userBar = View::factory('site/user_bar');

            //Stats::track($this->loginUserObj->getId(), 'request.received', array('uri'=>$_SERVER['REQUEST_URI']));
        } else {
            $this->loginUserObj = false;
        }

        //user id
        $this->modelUnit = new Model_Unit();
        $this->modelMessage = new Model_Message();
        $this->modelUser = new Model_User();
        $this->modelPage = new Model_Page();
        $this->modelReview = new Model_Review();
        $this->modelOrder = new Model_Order();
        $this->modelSearch = new Model_Search();
        $this->modelSettings = new Model_Settings();

        //search history
        $this->template->messageModal = View::factory('site/modals/message_logged2');
        $this->template->genericModal = View::factory('site/modals/generic');
        $this->template->specSearchs = $this->modelSearch->getSearch();
        $this->template->citySearchs = $this->modelSearch->getSearch(TRUE);		

        $this->template->buttons = View::factory('site/buttons');
        $professionObjs = Model_Unit::getUnitObjs('profession');
        $mortarObjs = Model_Unit::getUnitObjs('mortar');

        $this->template->buttons->titleObjs = array_merge($professionObjs,$mortarObjs);
        $this->template->buttons->cities = Model_Unit::getCityList();
        $this->template->buttons->amenityObjs = Model_Unit::getUnitObjs('amenity');

/*
        include_once(FS.'GoogleMap.php');
        include_once(FS.'JSMin.php');
*/

        if (!$this->loginUserObj)
        {
            $this->template->loginModal = View::factory('site/modals/login');
            $this->template->registerModal = View::factory('site/modals/register');
            $this->template->registerModal->professionObjs = $professionObjs;
            $this->template->registerModal->mortarObjs = $mortarObjs;

        }

        // userbar
        $MAP_OBJECT = new GoogleMapAPI();
        $MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;

        if ($this->loginUserObj) {
            $this->template->userBar->start = $MAP_OBJECT->getGeoCode($this->loginUserObj->getAddress().' '.$this->loginUserObj->getCity().', '.$this->loginUserObj->getZip());
            $this->template->userBar->mapObject = $MAP_OBJECT;
            $this->template->userBar->messageObjs = Model_Message::getMessageObjs($this->loginUserObj->getId(),'0','inbox',0,null,'0');
            //$this->template->userBar->invitationObjs = $this->loginUserObj->getInvitionUserObjs();
            $this->template->userBar->inviteObjs = $this->loginUserObj->getInviteObjs();

            if($this->loginUserObj->getRole() != Model_User::ROLE_USER)
            {
                $filter['check'] = TRUE;
                $this->template->userBar->reviewObjs = Model_Review::getReviewObjs($filter,0,4);
                //$this->template->reviewModal = View::factory('site/modals/review');
                $bfilter = array('sort'=>'b.date','order'=>'DESC','owner_id'=>$this->loginUserObj->getId(),'check'=>0);
                //$this->template->userBar->bookingOrderObjs = $this->loginUserObj->getBookingObjs($bfilter,0,4);
            }

            if($this->loginUserObj->isRoleUser())
            {
                $cartObjs = $this->loginUserObj->getCartOrderObjs();
                if($cartObjs)
                {
                    $items = array();
                    foreach ($cartObjs as $cartObj) {
                        $itemObjs = Model_Orderitem::getOrderItemObjsByOrderId($cartObj->getId());
                        foreach ($itemObjs as $itemObj) {
                            $items[] = $itemObj;
                        }
                    }
                    $this->template->userBar->orderItemObjs = $items;
                    $this->template->userBar->clubObj = Model_User::getUserObjById($cartObj->getAttr('owner_id'));
                }

            }
        }

    }

}
