<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Bookinginvite extends Controller_Site_Private
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

        $this->template->content = View::factory('site/templates/bookinginvite/list');

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
        $this->template->content->addBookingModal = View::factory('site/templates/bookinginvite/modal_add_invite');

        $filter1 = array('sort'=>'name','order'=>'ASC','type'=>'connections','id'=>$this->target_user_id);
        $this->template->content->addBookingModal->memberObjs = $this->loginUserObj->getFriendObjs($filter1);

        if($this->loginUserObj->getRole() == Model_User::ROLE_BUSINESS)
        {
            $filter2 = array('sort'=>'name','order'=>'ASC','type'=>'staff','superior_id'=>$this->target_user_id);
            $this->template->content->addBookingModal->trainerObjs = $this->loginUserObj->getStaffObjs($filter2);	
        }
        else
        {
            $this->template->content->addBookingModal->trainerObjs = array($this->loginUserObj);
        }

        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'bookinginvite';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/bookinginvite/list_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['owner_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 10;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

            $bookingObjs = $this->loginUserObj->getBookingInviteObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getBookingInviteObjs($data));

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
}
