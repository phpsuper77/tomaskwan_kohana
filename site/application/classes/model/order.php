<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Order extends Model_Base {

    const STATUS_PAID = 'paid';

    /*
    const TYPE_TOUR = 'tour';
    const TYPE_CLASS = 'class';
    const TYPE_BOOKING = 'booking';
    const TYPE_SESSION = 'session';
    const TYPE_SPEC_OFFER = 'specoffer';
     */

    public function getOrders($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'modify_date';
        if(!$filter['order'])
            $filter['order'] = 'DESC';		

/*
        $prequery = 'SELECT o.*,u.avatar AS uavatar,u.name AS uname,u.email AS uemail,u.address AS uadress,u.city AS ucity,u.zip AS uzip,'.
            'u.phone AS uphone,c.avatar AS cavatar,c.name AS cname,c.email AS cemail,c.address AS cadress,c.city AS ccity,c.zip AS czip,'.
            'c.phone AS cphone FROM `order` AS o JOIN user AS u ON u.id=o.user_id JOIN user AS c ON c.id=o.owner_id WHERE status!=\'cart\'';
 */
        $prequery = 'SELECT * FROM `order` WHERE status!=\'cart\'';
        if($filter['user_id'])
        {
            $prequery .= ' AND user_id='.$filter['user_id'];
        }
        if($filter['owner_id'])
        {
            $prequery .= ' AND owner_id='.$filter['owner_id'];
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)		
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }	

    public function checkOwner($id,$owner_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE id=:id AND owner_id=:owner_id')
            ->bind(':owner_id', $owner_id)
            ->bind(':id', $id);

        $result = $query->execute()->as_array();
        if(count($result)>0)
            return TRUE;
        else
            return FALSE;
    }

    public function checkStaff($id,$staff_id) {
        $query = DB::query(Database::SELECT, 'SELECT o.* FROM `order` AS o JOIN user AS u ON o.owner_id=u.superior.id WHERE o.id=:id AND u.id=:staff_id')
            ->bind(':staff_id', $staff_id)
            ->bind(':id', $id);

        $result = $query->execute()->as_array();

        if(count($result)>0)
            return TRUE;
        else
            return FALSE;
    }

    public function getOrderById($id,$user_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE id = :id AND (user_id = :user_id OR owner_id = :user_id)')
            ->bind(':id', $id)
            ->bind(':user_id', $user_id);
        $result = $query->execute()->as_array();
        return $result[0];
    }	

    public function getCartOrders($user_id, $owner_id = false) {
        $filter = '';
        if ($owner_id) {
            $filter = ' and owner_id=\''.$owner_id.'\'';
        }
        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE user_id=:user_id '.$filter.' AND status=\'cart\'')
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        return $result->as_array();
    }

    public function getCart($user_id, $owner_id = false) {
        $filter = '';
        if ($owner_id) {
            $filter = ' and owner_id=\''.$owner_id.'\'';
        }
        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE user_id=:user_id '.$filter.' AND status=\'cart\' LIMIT 1')
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        return $result->as_array();
    }

    // objects
    public static function checkTour($user_id,$club_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM booking WHERE user_id=:user_id AND trainer_id=:club_id AND type=\'tour\'')
            ->bind(':user_id', $user_id)
            ->bind(':club_id', $club_id);
        $result = $query->execute()->as_array();
        if(count($result)>0)
            return TRUE;
        else
            return FALSE;
    }

    public static function payOrder($user_id, $id) {
        $query = DB::query(Database::UPDATE, 'UPDATE `order` SET modify_date=:modify_date,status=\'paid\' WHERE id=:id AND owner_id=:user_id')
            ->bind(':modify_date', date('Y-m-d H:i:s'))
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('order', $id));
    }

    public static function getOpKeyByOrderId($orderObj) {
        $ownerObj = Model_User::getUserObjById($orderObj->getAttr('owner_id'));
        $billSettingObj = $ownerObj->getBillingSettingObj();
        if ($billSettingObj->isAttr("op_key")) {
            $op_key = $billSettingObj->getAttr("op_key");
        }
        return $op_key;
    }

    public static function paymentSuccess($user_id, $op_order) {
        LogManager::info("Payment started user_id=$user_id op_order=$op_order", LogManager::TYPE_PAYMENT);

        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE user_id = :user_id AND op_order = :op_order')
            ->bind(':op_order', $op_order)
            ->bind(':user_id', $user_id);
        $result = $query->execute()->as_array();
        $order = $result[0];
        $sum = $order['sum'];

/*
        $db = Database::instance();
        $db->begin();
*/

        $status = Model_Order::STATUS_PAID;
        $query = DB::query(Database::UPDATE, 'UPDATE `order` SET op_error=:op_error,status=:status,modify_date=:modify_date,op_end=:op_end WHERE id=:id and user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':status', $status)
            ->bind(':op_error', $op_error)
            ->bind(':id', $order['id'])
            ->bind(':modify_date', date('Y-m-d H:i:s'))
            ->bind(':op_end', date('Y-m-d H:i:s'));
        $result = $query->execute();
/*
        if (!$result) {
            $db->rollback();
            LogManager::error("Payment success #1 failed for user_id=$user_id op_order=$op_order", LogManager::TYPE_PAYMENT);
            return;
        }
*/

        // also all order_item
        $status = Model_OrderItem::STATUS_PAID;
        $query = DB::query(Database::UPDATE, 'UPDATE order_item SET status=:status WHERE order_id=:order_id and user_id=:user_id')
                ->bind(':user_id', $user_id)
                ->bind(':status', $status)
                ->bind(':order_id', $order['id']);
        $result = $query->execute();
/*
        if (!$result) {
            $db->rollback();
            LogManager::error("Payment success #2 failed for user_id=$user_id op_order=$op_order", LogManager::TYPE_PAYMENT);
            return;
        }
*/

        // make event visible
        $status = Model_Event::STATUS_ACTIVE;
        $query = DB::query(Database::UPDATE, 'UPDATE event SET status=:status WHERE order_id=:order_id')
            ->bind(':status', $status)
            ->bind(':order_id', $order['id']);
        $result = $query->execute();
/*
        if (!$result) {
            $db->rollback();
            LogManager::error("Payment success #3 failed for user_id=$user_id op_order=$op_order", LogManager::TYPE_PAYMENT);
            return;
        }
*/

        LogManager::info("Payment done for user_id=$user_id op_order=$op_order", LogManager::TYPE_PAYMENT);
        //$db->commit();

        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('order', $order['id']));

        return $sum;
    }

    public static function paymentError($user_id, $op_order, $op_error) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE op_order = :op_order')
            ->bind(':op_order', $op_order);
        $result = $query->execute()->as_array();
        $order = $result[0];

        $status = 'cart'; // or failed
        $query = DB::query(Database::UPDATE, 'UPDATE `order` SET op_error=:op_error,status=:status,modify_date=:modify_date,op_end=:op_end WHERE op_order=:op_order and user_id=:user_id')
            ->bind(':status', $status)
            ->bind(':op_error', $op_error)
            ->bind(':user_id', $user_id)
            ->bind(':op_order', $op_order)
            ->bind(':modify_date', date('Y-m-d H:i:s'))
            ->bind(':op_end', date('Y-m-d H:i:s'));
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('order', $order['id']));
    }

    public static function paymentErrorByTxId($user_id, $txid, $op_error) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM `order` WHERE txid = :txid')
            ->bind(':txid', $txid);
        $result = $query->execute()->as_array();
        $order = $result[0];

        $status = 'cart'; // or failed
        $query = DB::query(Database::UPDATE, 'UPDATE `order` SET op_error=:op_error,status=:status,modify_date=:modify_date,op_end=:op_end WHERE txid=:txid and user_id=:user_id')
            ->bind(':status', $status)
            ->bind(':op_error', $op_error)
            ->bind(':user_id', $user_id)
            ->bind(':txid', $txid)
            ->bind(':modify_date', date('Y-m-d H:i:s'))
            ->bind(':op_end', date('Y-m-d H:i:s'));
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('order', $order['id']));
    }

    private static function initiatePayment($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE `order` SET txid=:txid,sum=:sum,op_host=:op_host,op_order=:op_order,op_start=:op_start WHERE id = :id and user_id=:user_id')
            ->bind(':txid', $data['txid'])
            ->bind(':sum', $data['sum'])
            ->bind(':op_host', $data['op_host'])
            ->bind(':op_order', $data['op_order'])
            ->bind(':op_start', date('Y-m-d H:i:s'))
            ->bind(':user_id', $user_id)
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('order', $data['id']));
    }

    public static function paymentStart($user_id, $data) {
        $orderObj = self::getOrderObjById($user_id, $data['id']);
        $userObj = $orderObj->getUserObj();
        $ownerObj = $orderObj->getOwnerObj();
        $op_key = self::getOpKeyByOrderId($orderObj);
        $txid  = $orderObj->getId().'-'.time();
        $txdata = array();
        $txdata['key'] = $op_key;
        $txdata['id'] = $txid;
        $txdata['sum'] = $data['sum'];
        $txdata['success'] = Kohana::$config->load('site')->get('main.url').'cart/op_success';
        $txdata['error'] = Kohana::$config->load('site')->get('main.url').'cart/op_error';
        $txdata['customerMail'] = $userObj->getEmail();
        $txdata['merchantMail'] = $ownerObj->getEmail();
        $res = Util::payTransaction($txdata);
        if (isset($res['id'])) {
            $status = array();
            $status['op_order'] = $res['id'];
            $status['op_host'] = $res['link'][0]['uri'];
            $status['txid'] = $txid;
            $status['id'] = $orderObj->getId();
            $status['sum'] = $data['sum'];
            self::initiatePayment($user_id, $status);
            return $status['op_host'];
        } else {
            Cookie::set('error',$res['error']['message']);
            return false;
        }
    }

    public static function addOrder($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO `order` (user_id,owner_id,date,modify_date,status,form,sum) VALUES (:user_id,:owner_id,:date,:modify_date,:status,:form,:sum)')
            ->bind(':user_id', $user_id)
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':date', $data['date'])
            ->bind(':modify_date', $data['date'])
            ->bind(':status', $data['status'])
            ->bind(':form', $data['form'])
            ->bind(':sum', $data['sum']);
        $result = $query->execute();
        return $result[0];
    }

    public static function deleteCart($user_id, $id) {
        $query = DB::query(Database::DELETE, 'UPDATE `order` SET deleted=1 WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('order', $id));
    }

    public static function getCartObj($user_id) {
        $ret = false;
        $factory = new Model_Order();
        $attrs_set = $factory->getCart($user_id);
        if (count($attrs_set) == 1) {
            $ret = new Model_Order();
            $ret->setAttrs($attrs_set[0]);
        }
        return $ret;
    }

    public static function getCartOrderObjs($user_id) {
        $ret = array();
        $factory = new Model_Order();
        $attrs_set = $factory->getCartOrders($user_id);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Order();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
    public static function getCartObjByOwnerId($user_id, $owner_id) {
        $ret = false;
        $factory = new Model_Order();
        $attrs_set = $factory->getCart($user_id, $owner_id);
        if (count($attrs_set) == 1) {
            $ret = new Model_Order();
            $ret->setAttrs($attrs_set[0]);
        }
        return $ret;
    }

    /*
    public static function getOrderItemObjsByOrderId($order_id) {
        $ret = array();
        $factory = new Model_Orderitem();
        $attrs_set = $factory->getOrderItemObjsByOrderId($order_id);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Orderitem();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

   */
    /*
    public static function getBookingObjsByOrderId($order_id) {
        $ret = array();
        $factory = new Model_Order();
        $attrs_set = $factory->getBookingsByOrderId($order_id);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Order();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
     */

    public static function getOrderObjById($user_id, $id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('order', $id));
        if ($ret === null) {
            $factory = new Model_Order();
            $attrs = $factory->getOrderById($id, $user_id);
            if ($attrs) 
            {
                $ret = new Model_Order();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('order', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getOrderObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Order();
        $attrs_set = $factory->getOrders($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Order();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
/*
    public static function getBookingObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Order();
        $attrs_set = $factory->getBookingList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Order();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
 */

    public function getType() {
        return $this->getAttr('type');
    }

    /*
    public function isTypeBooking() {
        return $this->getAttr('type') == self::TYPE_BOOKING;
    }

    public function isTypeTour() {
        return $this->getAttr('type') == self::TYPE_TOUR;
    }

    public function isTypeClass() {
        return $this->getAttr('type') == self::TYPE_CLASS;
    }
     */

    public function getTrainerObj() {
        return Model_User::getUserObjById($this->getAttr('trainer_id'));
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getOwnerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getClassObj() {
        return Model_Class::getClassObjById($this->getAttr('class_id'));
    }

    public function getUserName() {
        return $this->getAttr('uname');
    }

    public function isStatusPaid() {
        return $this->getAttr('status') == 'paid';
    }

    public function isStatusPending() {
        return $this->getAttr('status') == 'pending';
    }

    public function getStatus() {
        return $this->getAttr('status');
    }

    public function getTrainerId() {
        return $this->getAttr('trainer_id');
    }

    public function getAvatarUrl() {
        $ret = false;
        if ($this->isAttr('uavatar') && $this->getAttr('uavatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('user_id')."/avatar/".$this->getAttr('uavatar');
        }
        return $ret;
    }

    public function getOwnerAvatarUrl() {
        $ret = false;
        if ($this->isAttr('uoavatar') && $this->getAttr('uavatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('uoid')."/avatar/".$this->getAttr('uoavatar');
        }
        return $ret;
    }

    public function getClassAvatarUrl() {
        $ret = false;
        if ($this->isAttr('cavatar') && $this->getAttr('cavatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('cid')."/avatar/".$this->getAttr('cavatar');
        }
        return $ret;
    }

    public function getTrainerAvatarUrl() {
        $ret = false;
        if ($this->isAttr('tavatar') && $this->getAttr('tavatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('trainer_id')."/avatar/".$this->getAttr('tavatar');
        }
        return $ret;
    }

    public function getUserModifyDate() {
        return date('m/d/Y H:i',strtotime($this->getAttr('modify_date')));
    }

    public function getUserDate() {
        return date('m/d/Y H:i',strtotime($this->getAttr('date')));
    }

    public function getDate() {
        return date('m/d/Y H:i',strtotime($this->getAttr('date')));
    }
}
