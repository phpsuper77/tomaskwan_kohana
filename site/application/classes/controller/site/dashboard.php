<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Dashboard extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

        $this->modelDashboard = new Model_Dashboard();
    }

/*
    public function action_schedule()
    {
        $this->template->content = View::factory('site/templates/dashboard/schedule');

        $filter = array('sort'=>'b.date','order'=>'DESC','user_id'=>$this->loginUserObj->getId());
        $this->template->content->bookingObjs = $this->loginUserObj->getBookingObjs($filter);

        $this->template->content->addBookingModal = View::factory('site/templates/page/modal_add_booking');
        $this->template->content->addBookingModal->mode = 'dashboard';

        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'dashboard';
    }
*/

    public function action_index_user()
    {
        $this->template->content = View::factory('site/templates/dashboard/index_user');
        $filter = array('sort'=>'date','order'=>'DESC','user_id'=>$this->loginUserObj->getId());
        $this->template->content->orderItemObjs = array();
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'dashboard';
    }

    public function action_index_admin()
    {
        $data = Arr::map('sanitizeValue', $this->request->post());
        if($data['from'])
        {
            $data['from'] = date('Y-m-d',strtotime($data['from']));
        }
        if($data['to'])
        {
            $data['to'] = date('Y-m-d',strtotime($data['to']));
        }

        $this->template->content = View::factory('site/templates/dashboard/index_admin');
        $this->template->content->from = $data['from'];
        $this->template->content->to = $data['to'];

        $this->template->content->countAccount = Model_Dashboard::getAccountCount();
        $this->template->content->countRevenue = Model_Dashboard::getRevenueCount();
        $this->template->content->visits = getAnalytics();

        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'dashboard';
    }

    public function action_index_business()
    {
        $this->template->content = View::factory('site/templates/dashboard/index_business');
        $data = Arr::map('sanitizeValue', $this->request->post());
        if($data['from'])
        {
            $data['from'] = date('Y-m-d',strtotime($data['from']));
        }
        if($data['to'])
        {
            $data['to'] = date('Y-m-d',strtotime($data['to']));
        }

        $filter1 = array('owner_id'=>$this->loginUserObj->getId(),'from'=>$data['from'],'to'=>$data['to']);
        //$this->template->content->bookingObjs = $this->loginUserObj->getBookingObjs($filter1,0,5);
        $this->template->content->bookingObjs = array();
        $filter2 = array('id'=>$this->loginUserObj->getId(),'from'=>$data['from'],'to'=>$data['to']);
        $this->template->content->reviewObjs = $this->loginUserObj->getReviewObjs($filter2,0,7);
        $this->template->content->connectionObjs = $this->loginUserObj->getConnectionObjs($filter2);

        $this->template->content->countMember = $this->loginUserObj->getMemberCount();
        $this->template->content->countRevenue = $this->loginUserObj->getRevenueCount();
        $this->template->content->countVisit = $this->loginUserObj->getVisitCount();

        $this->template->content->tourObj = $this->loginUserObj->getDashboardBookingObj($filter2,'tour');
        $this->template->content->classObj = $this->loginUserObj->getDashboardBookingObj($filter2,'class');
        $this->template->content->bookingObj = $this->loginUserObj->getDashboardBookingObj($filter2,'booking');

        $this->template->content->from = $data['from'];
        $this->template->content->to = $data['to'];			

        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'dashboard';
    }

    public function action_index()
    {
        // setup user for anything that we did not setup
        // during registration
        $this->loginUserObj->setup();

        // redirect user
        $role = $this->loginUserObj->getRole();
        if($role == Model_User::ROLE_USER) 
        {
            $this->action_index_user();
        }
        elseif($role == Model_User::ROLE_ADMIN)
        {
            $this->action_index_admin();
        }
        else
        {
            $this->action_index_business();
        }
    }

}
