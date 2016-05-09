<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Order extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $orderObj = $this->loginUserObj->getOrderObjById($id);
        if ($orderObj) {
            $itemObjs = Model_OrderItem::getOrderItemObjsByOrderId($orderObj->getId());
            $this->template->content = View::factory('site/templates/order/view');
            $this->template->content->orderObj = $orderObj;
            $this->template->content->userObj = $orderObj->getUserObj();
            $this->template->content->itemObjs = $itemObjs;

            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'payment';
            $this->template->content->sidebar->active = 'order';
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/order/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'payment';
        $this->template->content->sidebar->active = 'order';
        $this->template->content->detailsModal = View::factory('site/templates/order/modal_details');
    }

    public function action_list_ajax()
    {		
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/order/list_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['owner_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;
            $orderObjs = $this->loginUserObj->getOrderObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getOrderObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->orderObjs = $orderObjs;
            $this->template->modelOrder = $this->modelOrder;

            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
        {
            $this->request->redirect('/');	
        }
    }

    public function action_booking_ajax()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $this->template = View::factory('site/templates/order/booking_ajax');
            $this->template->bookingObjs = Model_Order::getBookingObjsByOrderId($data['order']);
        }
    }

    public function action_booking()
    {
        $route = sanitizeValue($this->request->param('route'));
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $cartObj = $this->loginUserObj->getCartObj();
            if($cartObj)
            {
                $dataBooking['order_id'] = $cartObj->getId();
            }
            else 
            {
                if($data['type']!='tour')
                {
                    $dataOrder['date'] = date('Y-m-d H:i:s');
                    $dataOrder['user_id'] = $this->loginUserObj->getId();
                    $dataOrder['status'] = 'cart';
                    $trainerObj = $this->loginUserObj->getUserObj($data['trainer']);
                    if($trainerObj->getAttr('superior_id') != NULL)
                        $dataOrder['owner_id'] = $trainerObj->getAttr('superior_id');
                    else
                        $dataOrder['owner_id'] = $data['trainer'];

                    $dataBooking['order_id'] = $this->loginUserObj->addOrder($dataOrder);
                }
            }

            $dataBooking['user_id'] = $this->loginUserObj->getId();
            $dataBooking['trainer_id'] = $data['trainer'];			
            $dataBooking['type'] = $data['type'];

            $x=0;
            foreach($data['date'] as $date)
            {			
                $dataBooking['date'] = $date;
                if($data['type'] == 'class')
                    $dataBooking['class_id'] = $data['class'][$x];
                $this->loginUserObj->addBooking($dataBooking);
                $x++;				
            }
        }
        $this->request->redirect('/page/'.$route);
    }

    public function action_pay()
    {
        $id = sanitizeValue($this->request->param('route'));

        // weird, only user can pay?
        if($this->loginUserObj->isRoleUser())
        {
            $this->request->redirect('/');
        }

        $orderObj = $this->loginUserObj->getOrderObjById($id);
        if(!$orderObj) 
        {
/*
            if ($this->modelOrder->checkStaff($id,$this->loginUserObj->getId())==FALSE)
            {
 */
            $this->request->redirect('/order/list');
/*
            }
 */
        }
        $this->loginUserObj->payOrder($id);
        Cookie::set('success','pay');
        $this->request->redirect('/order/list');

    }

/*
    public function action_pay_online()
    {
        $id = sanitizeValue($this->request->param('route'));
        if (!$id)
        {
            $this->request->redirect('/order/list');
        }
        $orderObj = $this->loginUserObj->getOrderObjById($id);
        if($orderObj)
        {			
            $order = $orderObj->getAttrs();
            if(!$order['op_host'])
            {
                $order['key'] = $this->modelSettings->getOpKey($order['owner_id']);
                $businessUserObj = Model_User::getUserObjById($order['owner_id']);
                $order['merchantMail'] = $businessUserObj->getEmail();
                $order['customerMail'] = $this->loginUserObj->getEmail();
                $order['success'] = FULLPATH.PATH.'/order/success/'.$id;
                $order['error'] = FULLPATH.PATH.'/order/error';

                //sending request to op
                $data = payTransaction($order);

                if(isset($data->error))
                {
                    Cookie::set('error',$data->error->message);	
                    $this->request->redirect('/order/list');					
                }
                else
                {
                    $order['op_host'] = $data->link[0]->uri;
                    $order['op_order'] = $data->id;
                    $this->loginUserObj->updateOrder($order);					
                }				
            }
            //redirect to op host
            $this->request->redirect($order['op_host']);

        }
        else
        {
            $this->request->redirect('/order/list');
        }
    }
 */

/*
    public function action_success()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        if(isset($data['id']))
        {
            $id = sanitizeValue($this->request->param('route'));
            $orderObj = $this->loginUserObj->getOrderObjById($id);
            $data['key'] = $this->modelSettings->getOpKey($orderObj->getAttr('owner_id'));

            //checking status
            $response = checkTransaction($data);
            if($response->transaction->status == 'success')
            {
                $this->loginUserObj->payOrder($response->merchantRefNum);
                Cookie::set('success','pay');
            }
        }
        $this->request->redirect('/order/list');	
    }

    public function action_error()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());
        Cookie::set('error',$data['transaction_errorMessage']);	
        $this->request->redirect('/order/list');	
    }
 */

    /*
    public function action_specoffer()
    {	
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $cartObj = $this->loginUserObj->getCartObj();
            if($cartObj)
            {
                $data['order_id'] = $cartObj->getId();
            }
            else 
            {
                $dataOrder['date'] = date('Y-m-d H:i:s');
                $dataOrder['user_id'] = $this->loginUserObj->getId();
                $dataOrder['status'] = 'cart';
                $dataOrder['owner_id'] = $data['owner_id'];

                $data['order_id'] = $this->loginUserObj->addOrder($dataOrder);
            }

            $data['user_id'] = $this->loginUserObj->getId();
            $data['type'] = 'specoffer';
            $data['date'] = date('Y-m-d H:i:s');
            $this->loginUserObj->addBooking($data);
            $this->request->redirect('/page/index/'.$data['route']);
        }
        else
        {
            $this->request->redirect('/');	
        }
    }
     */

    /*
    public function action_delete()
    {

        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteCart($id);
        $this->request->redirect('/order/cart');
    }

    public function action_op_success()
    {
        // retrieve call from optimal payment
        $op_order = $_GET['id'];
        Model_Order::paymentSuccess($this->loginUserObj->getId(), $op_order);
        $this->request->redirect('/order/list');
    }

    public function action_op_error()
    {
        if (isset($_GET['id'])) {
            $op_error = $_GET['transaction_errorMessage'];
            Model_Order::paymentError($this->loginUserObj->getId(), $_GET['id'], $op_error);
            Cookie::set('error', $op_error);
        } else if (isset($_GET['nbx_merchant_reference'])) {
            $nbx_merchant_reference = $_GET['nbx_merchant_reference'];
            $op_error = $_GET['nbx_status'];
            Model_Order::paymentErrorByTxId($this->loginUserObj->getId(), $nbx_merchant_reference, $op_error);
            Cookie::set('error', $op_error);
        }
        $this->request->redirect('/order/cart');

    }
     */

   /*
    public function action_cart()
    {
        if (!$this->loginUserObj->isRoleUser())
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['modify_date'] = date('Y-m-d H:i:s');
            $url = Model_Order::paymentStart($this->loginUserObj->getId(),$data);
            if ($url) {
                $this->request->redirect($url);
                Cookie::set('success','finalize');	
            }
        }	

        $this->template->content = View::factory('site/templates/order/cart');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'cart';

        $this->template->content->checkoutModal = View::factory('site/modals/checkout');
        $this->template->content->addBookingModal = View::factory('site/modals/add_booking');
        $this->template->content->addBookingModal->mode = 'cart';

        $cartObj = $this->loginUserObj->getCartObj();
        if($cartObj)
        {
            $this->template->content->cartObj = $cartObj;
            $this->template->content->bookingObjs = Model_Order::getBookingObjsByOrderId($cartObj->getId());
            if($this->modelSettings->getOpKey($cartObj->getAttr('owner_id')) == NULL)
            {
                $this->template->content->checkoutModal->card = 'disable';
            }
        }
    }
*/
}
