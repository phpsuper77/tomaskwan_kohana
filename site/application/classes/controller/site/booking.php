<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Booking extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

        //check if user is logged
/*
        if (Auth::instance()->logged_in_user() == NULL || $this->user['role'] == Model_User::ROLE_ADMIN)
            $this->request->redirect('/');
 */

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
        if ($this->loginUserObj->getRole() == Model_User::ROLE_USER)
        {
            $this->request->redirect('/');
        }		

        $this->template->content = View::factory('site/templates/booking/list');

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            if($data['submit'] == 'add')
            {		
                //add order
                $dataOrder = $data;
                $dataOrder['date'] = date('Y-m-d H:i:s');
                $dataOrder['owner_id'] = $this->loginUserObj->getId();
                $dataOrder['status'] = 'pending';
                $data['order_id'] = $this->loginUserObj->addOrder($dataOrder);

                //add booking
                $data['type'] = 'booking';
                $this->loginUserObj->addBooking($data);
                Cookie::set('success','addBooking');

            }
            if($data['submit'] == 'edit')
            {		
                $this->loginUserObj->updateBooking($data);
                Cookie::set('success','editBooking');
                if($data['mode'] == 'dashboard')
                    $this->request->redirect('/dashboard');

            }		
        }		

        $this->template->content->sidebar = View::factory('site/sidebar');

        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'booking';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('ajax/booking');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['owner_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 10;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $bookingObjs = $this->loginUserObj->getBookingObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getBookingObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->bookingObjs = $bookingObjs;

            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
            $this->request->redirect('/');	
    }

    public function action_table_calendar()
    {
        if(isset($_POST['submit']))
        {
            //model
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            if($data['type'] == 'calendar')
            {
                $this->template = View::factory('ajax/week_calendar2');
            }
            else
            {
                $this->template = View::factory('ajax/week_calendar');
            }

            $trainerObj = Model_User::getUserObjById($data['trainer_id']);
            $this->template->trainerObj = $trainerObj;

            $modelClass = new Model_Class();
            $modelSettings = new Model_Settings();
            $this->template->modelOrder = $this->modelOrder;
            $this->template->modelClass = $modelClass;
            $this->template->modelSettings = $modelSettings;
        }
        else
        {	
            $this->request->redirect('/');	
        }
    }

    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteBooking($id);
        $this->request->redirect('/booking/list');
    }

    public function action_calendar()
    {
        $role = $this->loginUserObj->getRole();
        if ($role == Model_User::ROLE_ADMIN || $role == Model_User::ROLE_USER)
        {
            $this->request->redirect('/');
        }

        $this->template->content = View::factory('site/templates/calendar');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'calendar';
        $this->template->content->bookingInfoModal = View::factory('site/modals/booking_info');

        $filter = array('sort'=>'name','order'=>'ASC','type'=>'staff','superior_id'=>$this->loginUserObj->getId());
        $this->template->content->trainerObjs = $this->loginUserObj->getStaffObjs($filter);


        // XXX - TO DELETE
        $this->template->content->modelOrder = $this->modelOrder;
        $modelClass = new Model_Class();
        $modelSettings = new Model_Settings();
        $this->template->content->modelClass = $modelClass;
        $this->template->content->modelSettings = $modelSettings;
    }
}
