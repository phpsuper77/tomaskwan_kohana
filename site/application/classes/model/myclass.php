<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_MyClass extends Model_Base {

    public function getMyClassList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'name';
        if(!$filter['order'])
            $filter['order'] = 'ASC';
        $query = 'SELECT order_item.order_id, order_item.id as order_item_id, class.* FROM order_item '.
                    'join class on (class.id=order_item.object_id) WHERE '.
                    'order_item.type="class" and order_item.user_id=:user_id and order_item.deleted=0 AND '.
                    'order_item.status='.Model_OrderItem::STATUS_PAID;
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

    public static function getMyClassObjById($user_id, $id) {
        $query = 'SELECT order_item.order_id,order_item.id as order_item_id,class.* FROM order_item '.
                    'join class on (class.id=order_item.object_id) WHERE '.
                    'order_item.type="class" and order_item.id=:id and order_item.user_id=:user_id and '.
                    'order_item.deleted=0 AND order_item.status='.Model_OrderItem::STATUS_PAID;
        $query = DB::query(Database::SELECT,$query)
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $ret = $result->as_array();
        $obj = false;
        if (count($ret) == 1) {
            $obj = new Model_MyClass();
            $obj->setAttrs($ret[0]);
        }
        return $obj;
    }

    public static function getMyClassObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_MyClass();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getMyClassList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_MyClass();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getId() {
        return $this->getAttr('order_item_id');
    }

    public function getName() {
        return $this->getAttr('name'). ' (CLASS #'.$this->getId().')';
    }

    public function getPrice() {
        return $this->getAttr('price');
    }

    public function getDateFrom() {
        return $this->getDateAttr('date_from');
    }

    public function getDateTo() {
        return $this->getDateAttr('date_to');
    }

    public function getTimeFrom() {
        return $this->getTimeAttr('time_from');
    }

    public function getTimeTo() {
        return $this->getTimeAttr('time_from');
    }

    public function getWeekdays() {
        $ret = '';
        $hash = $this->getWeekHash();
        for ($i = 1; $i <= 7; $i++) {
            if (isset($hash[$i])) {
                switch ($i) {
                case 1:
                    $day = 'Monday';
                    break;
                case 2:
                    $day = 'Tuesday';
                    break;
                case 3:
                    $day = 'Wednesday';
                    break;
                case 4:
                    $day = 'Thursday';
                    break;
                case 5:
                    $day = 'Friday';
                    break;
                case 6:
                    $day = 'Saturday';
                    break;
                case 7:
                    $day = 'Sunday';
                    break;
                }
                if ($ret != '') {
                    $ret .= ", ";
                } 
                $ret .= $day;
            }
        }
        return $ret;
    }

    public function getWeekHash() {
        $ret = array_flip(unserialize($this->getAttr('week')));
        return $ret;
    }

    public function getLocationObj() {
        return Model_Location::getLocationObjById($this->getAttr('location_id'));
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getTrainerObj() {
        $ret = Model_User::getUserObjById($this->getAttr('trainer_id'));
        return $ret;
    }
}
