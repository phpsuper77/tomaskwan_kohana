<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Orderitem extends Model_Base {

    const STATUS_PAID = '1';

    const TYPE_CLASS = 'class';
    const TYPE_SESSION = 'session';
    const TYPE_SPEC_OFFER = 'specoffer';
    const TYPE_TOUR = 'tour';

    //const TYPE_BOOKING = 'booking';

    public function getOrderItemList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'id';
        if(!$filter['order'])
            $filter['order'] = 'ASC';
        if(!$filter['from'])
            $filter['from'] = date('Y-m-d',strtotime('-14 days'));

        $prequery = 'SELECT * FROM order_item as b WHERE 1=1';

        if(isset($filter['owner_id']))
            $prequery .= ' AND (b.user_id = \''.$filter['owner_id'].'\' OR b.trainer_id = \''.$filter['owner_id'].'\')';

        if(isset($filter['check']))
            $prequery .= ' AND b.check = \''.$filter['check'].'\'';

        /*
        if(isset($filter['status']))
            $prequery .= ' AND o.status = \''.$filter['status'].'\'';
         */

        if(isset($filter['user_id']))
            $prequery .= ' AND b.user_id = \''.$filter['user_id'].'\'';
        if(isset($filter['type']))
            $prequery .= ' AND b.type = \''.$filter['type'].'\'';

        if($filter['to'])
            $prequery .= ' AND b.date BETWEEN \''.$filter['from'].'\' AND \''.$filter['to'].'\'';
        else
            $prequery .= ' AND b.date >= \''.$filter['from'].'\'';	

        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        return $result->as_array();

    }

    private static function getOrderItemById($id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM order_item WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        $list = $result->as_array();
        if (count($list) > 0) {
            $ret = $list[0];
        }
        return $ret;
    }

    public function checkBooking($date,$trainer_id = NULL,$user_id=NULL,$class_id = NULL) {
        $prequery = 'SELECT b.*,u.id AS uid,u.name,u.avatar,p.route FROM booking AS b JOIN user AS u ON b.user_id=u.id JOIN page AS p ON p.user_id=u.id WHERE b.date=:date'; 
        if($user_id != NULL)
            $prequery .= ' AND b.user_id = '.$user_id;
        if($class_id != NULL)
            $prequery .= ' AND b.class_id = '.$class_id;
        if($trainer_id != NULL)
            $prequery .= ' AND b.trainer_id = '.$trainer_id;
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':user_id', $user_id)
            ->bind(':date', $date);
        $result = $query->execute()->as_array();
        if(count($result)>0)
            return $result[0];
        else
            return FALSE;
    }

    public static function updateOrderItem($user_id, $data) {
        if (!isset($data['date'])) {
            $data['date'] = date('Y-m-d H:i:s');;
        }
        $item = self::getOrderItemById($data['id']);
        if ($item) {
            $query = DB::query(Database::UPDATE, 'UPDATE order_item SET date=:date WHERE id=:id AND user_id=:user_id')
                ->bind(':date', $data['date'])
                ->bind(':user_id', $user_id)
                ->bind(':id', $data['id']);
            $result = $query->execute();
            $cache = Cache::instance();
            $cache->delete(self::getCacheKey('orderitems', $item['order_id']));
        }
    }

    public static function addOrderItem($user_id, $data) {
        if (!isset($data['date'])) {
            $data['date'] = date('Y-m-d H:i:s');;
        }
        $query = DB::query(Database::INSERT, 'INSERT INTO order_item (order_id,user_id,owner_id,object_id,date,type,price) VALUES (:order_id,:user_id,:owner_id,:object_id,:date,:type,:price)')
            ->bind(':order_id', $data['order_id'])
            ->bind(':user_id', $user_id)
            ->bind(':price', $data['price'])
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':object_id', $data['object_id'])
            ->bind(':date', $data['date'])
            ->bind(':type', $data['type']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('orderitems', $data['order_id']));
    }

    public static function trashOrderItem($user_id, $id) {
        $item = self::getOrderItemById($id);
        $query = DB::query(Database::UPDATE, 'UPDATE order_item SET `check` = \'1\' WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('orderitems', $item['order_id']));
    }

    public static function deleteOrderItem($user_id, $id) {
        $item = self::getOrderItemById($id);
        $query = DB::query(Database::DELETE, 'UPDATE order_item SET deleted=1 WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('orderitems', $item['order_id']));
    }

    public function getOrderItemsByOrderId($order_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM order_item WHERE order_id=:order_id AND deleted=0')
            ->bind(':order_id', $order_id);
        $result = $query->execute();
        return $result->as_array();
    }

    public static function getOrderItemObjsByOrderId($order_id) {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('orderitems', $order_id));
        if ($ret === null) {
            $ret = array();
            $factory = new Model_Orderitem();
            $attrs_set = $factory->getOrderItemsByOrderId($order_id);
            foreach ($attrs_set as $attrs) {
                $obj = new Model_Orderitem();
                $obj->setAttrs($attrs);
                $ret[] = $obj;
            }
            $cache->set(self::getCacheKey('orderitems', $order_id), $ret);
        }
        return $ret;
    }

/*
    public static function getOrderItemObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Orderitem();
        $attrs_set = $factory->getOrderItemList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Orderitem();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
*/

    public function getType() {
        return $this->getAttr('type');
    }

    public function isTypeBooking() {
        return $this->getAttr('type') == self::TYPE_BOOKING;
    }

    public function isTypeTour() {
        return $this->getAttr('type') == self::TYPE_TOUR;
    }

    public function isTypeClass() {
        return $this->getAttr('type') == self::TYPE_CLASS;
    }

    public function isTypeSession() {
        return $this->getAttr('type') == self::TYPE_SESSION;
    }

    public function isTypeSpecOffer() {
        return $this->getAttr('type') == self::TYPE_SPEC_OFFER;
    }

    public function getItemObj() {
        $ret = false;
        if ($this->isTypeClass()) {
            $ret = Model_Class::getClassObjById($this->getAttr('object_id'));
        } else if ($this->isTypeSpecOffer()) {
            $ret = Model_Specoffer::getOfferObjById($this->getAttr('object_id'));
        } else if ($this->isTypeSession()) {
            $ret = Model_Event::getEventObjById($this->getAttr('object_id'));
        }
        return $ret;
    }

    public function getItemType() {
        $ret = $this->getAttr('type');
        if ($this->isTypeClass()) {
            $ret = 'Class';
        } else if ($this->isTypeSpecOffer()) {
            $ret = 'Special Offer';
        } else if ($this->isTypeSession()) {
            $ret = 'Private Session';
        }
        return $ret;
    }

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
        return Model_Class::getClassObjById($this->getAttr('object_id'));
    }

    public function getSessionObj() {
        return Model_Session::getSessionObjById($this->getAttr('object_id'));
    }

    public function getDate() {
        return date('m/d/Y H:i',strtotime($this->getAttr('date')));
    }
}
