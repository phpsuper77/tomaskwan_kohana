<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_MySession extends Model_Base {

    const STATUS_PENDING = 1;

    public function getMySessionList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'name';
        if(!$filter['order'])
            $filter['order'] = 'ASC';
        $query = 'SELECT order_item.order_id,order_item.id as order_item_id,session.* FROM order_item '.
                    'join session on (order_item.object_id=session.id) WHERE '.
                    'order_item.type="session" AND order_item.user_id=:user_id and '.
                    'order_item.deleted=0 AND order_item.status='.Model_OrderItem::STATUS_PAID;
        if($filter['search'])
            $query .= ' AND name LIKE %'.$filter['search'].'% ';
        $query .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $query)
            ->bind(':user_id', $filter['user_id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }

    public static function getMySessionObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_MySession();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getMySessionList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_MySession();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getMySessionObjById($user_id, $id) {
        $query = 'SELECT order_item.order_id,order_item.id as order_item_id,session.* FROM order_item '.
                        'join session on (order_item.object_id=session.id) WHERE '.
                        'order_item.type="session" AND order_item.id=:id AND order_item.user_id=:user_id and '.
                        'order_item.deleted=0 AND order_item.status='.Model_OrderItem::STATUS_PAID;
        $query = DB::query(Database::SELECT,$query)
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $ret = $result->as_array();
        $obj = false;
        if (count($ret) == 1) {
            $obj = new Model_MySession();
            $obj->setAttrs($ret[0]);
        }
        return $obj;
    }

    public function getId() {
        return $this->getAttr('order_item_id');
    }

    public function getName() {
        return date('m/d/Y H:i',strtotime($this->getTimeFrom())) . ' - ' . date('m/d/Y H:i',strtotime($this->getTimeTo())) . ' (SESSION #'.$this->getId().')';
    }

    public function getTimeFrom() {
        return $this->getAttr('time_from');
    }

    public function getTimeTo() {
        return $this->getAttr('time_to');
    }

    public function getTrainerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getLocationObj() {
        return Model_Location::getLocationObjById($this->getAttr('location_id'));
    }
}
