<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cart extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        if (!$this->loginUserObj->isRoleUser()) {
            $this->request->redirect('/');
        }
    }

    public function action_add_specoffer()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $offerObj = Model_Specoffer::getOfferObjById($data['offer_id']);
        $ownerObj = Model_User::getUserObjById($data['owner_id']);
        $price = $offerObj->getPrice();
        if ($offerObj) {
            if ($ownerObj) {
                $data['order_id'] = $this->loginUserObj->getOrderIdByOwnerId($ownerObj->getId());
                $data['user_id'] = $this->loginUserObj->getId();
                $data['owner_id'] = $ownerObj->getId();
                $data['object_id'] = $data['offer_id'];
                $data['price'] = $price;
                $data['type'] = Model_Orderitem::TYPE_SPEC_OFFER;
                $this->loginUserObj->addOrderItem($data);

                Stats::track($this->loginUserObj->getId(), 'cart.add', array('type'=>'spec_offer', 'id'=>$offerObj->getId()));
            }
        }

        $this->request->redirect('/cart/list');
    }

    public function action_add_session()
    {
        $data = Arr::map('sanitizeHTMLValue', $_GET);
        $ownerObj = Model_User::getUserObjById($data['owner_id']);
        $to_cart = false;
        if ($ownerObj) {
                $price = $data['price']; // TODO - do our price check on server

                $data['order_id'] = $this->loginUserObj->getOrderIdByOwnerId($ownerObj->getId());

                $hostObj = Model_User::getUserObjById($data['host_id']);

                // create new event for session for user
                $eventData['host_id'] = $hostObj->getId();
                $eventData['time_from'] = date('Y-m-d H:i:s', $data['start']);
                $eventData['time_to'] = date('Y-m-d H:i:s', $data['end']);
                $eventData['location_id'] = $data['location_id'];
                $eventData['user_id'] = $this->loginUserObj->getId();
                $eventData['owner_id'] = $ownerObj->getId();
                $eventData['type'] = Model_Event::TYPE_SESSION;
                if ($price == 0) {
                    $eventData['status'] = Model_Event::STATUS_ACTIVE;
                } else {
                    $eventData['status'] = Model_Event::STATUS_PENDING;
                    $eventData['order_id'] = $data['order_id'];
                }
                $eventData['price'] = $price;
                $data['object_id'] = $this->loginUserObj->addEvent($eventData);

                // create new event for trainer
                $eventData['user_id'] = $ownerObj->getId();
                $eventData['owner_id'] = $this->loginUserObj->getId();
                $ownerObj->addEvent($eventData);

                Stats::track($this->loginUserObj->getId(), 'cart.add', array('type'=>'session_manual', 'owner'=>$ownerObj->getId(), 'host'=>$hostObj->getId(), 'start_time'=>$eventData['time_from'], 'end_time'=>$eventData['time_to']));

                // then add it to order
                $data['owner_id'] = $ownerObj->getId();
                $data['user_id'] = $this->loginUserObj->getId();
                $data['price'] = $price;
                $data['type'] = Model_Orderitem::TYPE_SESSION;
                if ($price != 0) {
                    $to_cart = true;
                    $this->loginUserObj->addOrderItem($data);
                }
        }
        if ($to_cart) {
            $this->request->redirect('/cart/list');	
        } else {
            $this->request->redirect('/myevent/list');	
        }
    }

    public function action_add_sessions()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $ownerObj = Model_User::getUserObjById($data['owner_id']);
        $to_cart = false;
        if ($ownerObj) {
            foreach ($_POST['sessions'] as $s) {
                $session = json_decode($s, true);

                $price = $session['price']; // TODO - do our price check on server

                $hostObj = Model_User::getUserObjById($session['host_id']);
                $data['order_id'] = $this->loginUserObj->getOrderIdByOwnerId($hostObj->getId());

                // create new event for session for user
                $eventData['time_from'] = date('Y-m-d H:i:s', $session['start']);
                $eventData['time_to'] = date('Y-m-d H:i:s', $session['end']);
                $eventData['location_id'] = $session['location_id'];
                $eventData['user_id'] = $this->loginUserObj->getId();
                $eventData['owner_id'] = $ownerObj->getId();
                $eventData['host_id'] = $hostObj->getId();
                $eventData['type'] = Model_Event::TYPE_SESSION;
                if ($price == 0) {
                    $eventData['status'] = Model_Event::STATUS_ACTIVE;
                } else {
                    $eventData['status'] = Model_Event::STATUS_PENDING;
                    $eventData['order_id'] = $data['order_id'];
                }
                $eventData['price'] = $price;

                $data['object_id'] = $this->loginUserObj->addEvent($eventData);

                // create new event for trainer
                $eventData['user_id'] = $ownerObj->getId();
                $eventData['owner_id'] = $this->loginUserObj->getId();
                $ownerObj->addEvent($eventData);

                Stats::track($this->loginUserObj->getId(), 'cart.add', array('type'=>'session', 'owner'=>$ownerObj->getId(), 'host'=>$hostObj->getId(), 'start_time'=>$eventData['time_from'], 'end_time'=>$eventData['time_to']));

                // then add it to order
                $data['owner_id'] = $ownerObj->getId();
                $data['user_id'] = $this->loginUserObj->getId();
                $data['price'] = $price;
                $data['type'] = Model_Orderitem::TYPE_SESSION;
                if ($price != 0) {
                    $to_cart = true;
                    $this->loginUserObj->addOrderItem($data);
                }
            }
        }
        if ($to_cart) {
            $this->request->redirect('/cart/list');	
        } else {
            $this->request->redirect('/myevent/list');	
        }
    }

    public function action_add_classes()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $to_cart = false;
        foreach ($data['classes'] as $class) {
            $classObj = Model_Class::getClassObjById($class);
            Stats::track($this->loginUserObj->getId(), 'cart.add', array('type'=>'class', 'id'=>$classObj->getId()));
            $hostObj = $classObj->getUserObj();
            $trainerObj = $classObj->getTrainerObj();
            $locationObj = $classObj->getLocationObj();
            $price = $classObj->getPrice();
            if ($classObj) {
                if ($trainerObj) {
                    // create order
                    $data['order_id'] = $this->loginUserObj->getOrderIdByOwnerId($hostObj->getId());

                    $weekHash = $classObj->getWeekHash();

                    // create events for the class
                    $start_date = $classObj->getDateFromInSecs();
                    $end_date = $classObj->getDateToInSecs();
                    $count = 0;
                    for ($i = $start_date; $i <= $end_date; $i = $i + 24 * 60 * 60) {
                        $n = date("N", $i);
                        $d = date("Y-m-d", $i);
                        if (!isset($weekHash[$n])) {
                            continue;
                        }
                        $eventData['time_from'] = "$d " . $classObj->getAttr('time_from').':00';
                        $eventData['time_to'] = "$d " . $classObj->getAttr('time_to').':00';
                        if ($locationObj) {
                            $eventData['location_id'] = $locationObj->getId();
                        }
                        $eventData['user_id'] = $this->loginUserObj->getId();
                        $eventData['owner_id'] = $trainerObj->getId();
                        $eventData['host_id'] = $hostObj->getId();
                        $eventData['type'] = Model_Event::TYPE_CLASS;
                        $eventData['price'] = $price;
                        if ($price == 0) {
                            $eventData['status'] = Model_Event::STATUS_ACTIVE;
                        } else {
                            $eventData['order_id'] = $data['order_id'];
                            $eventData['status'] = Model_Event::STATUS_PENDING;
                        }
                        $eventData['object_id'] = $classObj->getId();
                        $this->loginUserObj->addEvent($eventData);
                        $count++;

                        if ($count > Model_Event::MAX_EVENTS_PER_ORDER) {
                            LogManager::error("Too many events ($count) for class=".$classObj->getId());
                            break;
                        }
                    }

                    // add info to order
                    $data['owner_id'] = $trainerObj->getId();
                    $data['user_id'] = $this->loginUserObj->getId();
                    $data['price'] = $classObj->getPrice();
                    $data['type'] = Model_Orderitem::TYPE_CLASS;
                    $data['object_id'] = $classObj->getId();
                    if ($price != 0) {
                        $this->loginUserObj->addOrderItem($data);
                        $to_cart = true;
                    }
                }
            }
        }

        if ($to_cart) {
            $this->request->redirect('/cart/list');	
        } else {
            $this->request->redirect('/myevent/list');	
        }
    }

    public function action_checkout()
    {
        $url = '/cart/list';
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['modify_date'] = date('Y-m-d H:i:s');
            Stats::track($this->loginUserObj->getId(), 'checkout.start');
            $purl = Model_Order::paymentStart($this->loginUserObj->getId(),$data);
            if ($purl) {
                $url = $purl;
                Cookie::set('success','finalize');
            }
        }
        $this->request->redirect($url);
    }

    public function action_op_success()
    {
        // retrieve call from optimal payment
        $op_order = $_GET['id'];
        $sum = Model_Order::paymentSuccess($this->loginUserObj->getId(), $op_order);
        Stats::track($this->loginUserObj->getId(), 'checkout.success');
        Stats::trackCharge($this->loginUserObj->getId(), $sum);
        $this->request->redirect('/myorder/list');
    }

    public function action_op_error()
    {
        if (isset($_GET['id'])) {
            $op_error = $_GET['transaction_errorMessage'];
            Stats::track($this->loginUserObj->getId(), 'checkout.error', array('error'=>$op_error));
            Model_Order::paymentError($this->loginUserObj->getId(), $_GET['id'], $op_error);
            Cookie::set('error', $op_error);
        } else if (isset($_GET['nbx_merchant_reference'])) {
            $nbx_merchant_reference = $_GET['nbx_merchant_reference'];
            $op_error = $_GET['nbx_status'];
            Stats::track($this->loginUserObj->getId(), 'checkout.error', array('error'=>$op_error, 'ref'=>$nbx_merchant_reference));
            Model_Order::paymentErrorByTxId($this->loginUserObj->getId(), $nbx_merchant_reference, $op_error);
            Cookie::set('error', $op_error);
        }
        $this->request->redirect('/cart/list');
    }

    public function action_list()
    {
        if (!$this->loginUserObj->isRoleUser())
        {
            $this->request->redirect('/');
        }

        $this->template->content = View::factory('site/templates/cart/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'payment';
        $this->template->content->sidebar->active = 'cart';

        $this->template->content->checkoutModal = View::factory('site/templates/cart/modal_checkout');
/*
        $this->template->content->addBookingModal = View::factory('site/templates/page/modal_add_booking');
        $this->template->content->addBookingModal->userObj = $this->loginUserObj;
        $this->template->content->addBookingModal->mode = 'cart';
 */

        $cartObjs = $this->loginUserObj->getCartOrderObjs();
        $orderObjs = array();
        foreach ($cartObjs as $cartObj)
        {
            $orderItemObjs = Model_Orderitem::getOrderItemObjsByOrderId($cartObj->getId());
            $orderObj = array();
            $orderObj['cartObj'] = $cartObj;
            $orderObj['orderItemObjs'] = $orderItemObjs;
            if (count($orderItemObjs) > 0) {
                $orderObjs[] = $orderObj;
            }
            /*
            if($this->modelSettings->getOpKey($cartObj->getAttr('owner_id')) == NULL)
            {
                $this->template->content->checkoutModal->card = 'disable';
            }
             */
        }
        //$this->template->content->cartObj = $cartObj;
        $this->template->content->orderObjs = $orderObjs;
    }

    public function action_empty()
    {
        $cartObjs = $this->loginUserObj->getCartOrderObjs();
        foreach ($cartObjs as $cartObj)
        {
        //    $this->loginUserObj->deleteCart($cartObj->getId());
            $orderItemObjs = Model_Orderitem::getOrderItemObjsByOrderId($cartObj->getId());
            foreach ($orderItemObjs as $orderItemObj) {
                $this->loginUserObj->deleteOrderItem($orderItemObj->getId());
            }
            $this->loginUserObj->deleteCart($cartObj->getId());
        }
        Stats::track($this->loginUserObj->getId(), 'cart.empty');
        $this->request->redirect('/cart/list');
    }

    public function action_delete_orderitem()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteOrderItem($id);
        Stats::track($this->loginUserObj->getId(), 'cart.deleteitem', array('id'=>$id));
        $this->request->redirect('/cart/list');
    }

}
