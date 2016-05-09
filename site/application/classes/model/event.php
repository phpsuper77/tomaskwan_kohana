<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Event extends Model_Base {

    const MAX_EVENTS_PER_ORDER = 200;

    const TYPE_SESSION = 1;
    const TYPE_TOUR = 2;
    const TYPE_CLASS = 3;
    const TYPE_CUSTOM_SESSION = 4;

    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;

    public function getEventList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'id';
        if(!$filter['order'])
            $filter['order'] = 'ASC';
        if(!$filter['status'])
            $filter['status'] = self::STATUS_ACTIVE;
        $prequery = 'SELECT * FROM event WHERE deleted=0 and status=:status';
        if ($filter['user_id']) {
            $prequery .= ' and user_id="' .$filter['user_id'] . '"';
        }
        if ($filter['host_id']) {
            $prequery .= ' and host_id="' .$filter['host_id'] . '"';
        }
        if ($filter['type']) {
            $prequery .= ' and type="' .$filter['type'] . '"';
        }
        if ($filter['start_date']) {
            $prequery .= ' and time_from>="' .$filter['start_date'] . ' 00:00:00"';
        }
        if ($filter['end_date']) {
            $prequery .= ' and time_to<="' .$filter['end_date'] . ' 00:00:00"';
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':status', $filter['status'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        return $result->as_array();
    }

    public static function addEvent($user_id, $data) {
        if (!isset($data['date'])) {
            $data['date'] = date('Y-m-d H:i:s');
        }
        $data['room'] = '';
        $query = DB::query(Database::INSERT, 'INSERT INTO event ('.
                'user_id,owner_id,time_from,time_to,location_id,status,date,price,type,object_id,order_id,room,host_id'.
            ') VALUES ('.
                ':user_id,:owner_id,:time_from,:time_to,:location_id,:status,:date,:price,:type,:object_id,:order_id,:room,:host_id'.
            ')')
            ->bind(':user_id', $user_id)
            ->bind(':room', $data['room'])
            ->bind(':host_id', $data['host_id'])
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':order_id', $data['order_id'])
            ->bind(':type', $data['type'])
            ->bind(':price', $data['price'])
            ->bind(':time_from', $data['time_from'])
            ->bind(':time_to', $data['time_to'])
            ->bind(':location_id', $data['location_id'])
            ->bind(':object_id', $data['object_id'])
            ->bind(':status', $data['status'])
            ->bind(':date', $data['date']);
        $result = $query->execute();
        return $result[0];
    }

    public static function getEventObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Event();
        $attrs_set = $factory->getEventList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Event();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getUpcomingEventObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Event();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getEventList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Event();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getEventObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('event', $id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT,'SELECT * FROM event WHERE id=:id and deleted=0')
                    ->bind(':id', $id);
            $result = $query->execute();
            $list = $result->as_array();
            if (count($list) == 1) {
                $ret = new Model_Event();
                $ret->setAttrs($list[0]);
                $cache->set(self::getCacheKey('event', $id), $ret);
            }
        }
        return $ret;
    }

    public function getName() {
        if ($this->getAttr('type') == self::TYPE_CLASS) {
            $ret = $this->getClassObj()->getName();
        } else {
            $ret = $this->getEventType() . ' ' . date('m/d/Y',strtotime($this->getTimeFrom())) . ' ' . date('H:i',strtotime($this->getTimeFrom())) . '-' . date('H:i',strtotime($this->getTimeTo()));
        }
        return $ret;
    }

    public function getUserTimeFrom() {
        return date("m/d/Y H:i", strtotime($this->getAttr('time_from')));
    }

    public function getUserTimeTo() {
        return date("m/d/Y H:i", strtotime($this->getAttr('time_to')));
    }

    public function getTimeFrom() {
        return $this->getAttr('time_from');
    }

    public function getTimeTo() {
        return $this->getAttr('time_to');
    }

    public function getTimeFromInSecs() {
        return strtotime($this->getAttr('time_from'));
    }

    public function getTimeToInSecs() {
        return strtotime($this->getAttr('time_to'));
    }


    public function isTypeClass() {
        return ($this->getAttr('type') == self::TYPE_CLASS);
    }

    public function isTypeSession() {
        return ($this->getAttr('type') == self::TYPE_SESSION);
    }

    public function isTypeTour() {
        return ($this->getAttr('type') == self::TYPE_TOUR);
    }

    public function getEventType() {
        $ret = '';
        if ($this->getAttr('type') == self::TYPE_SESSION) {
            $ret = 'session';
        } else if ($this->getAttr('type') == self::TYPE_CLASS) {
            $ret = 'class';
        } else if ($this->getAttr('type') == self::TYPE_TOUR) {
            $ret = 'tour';
        }
        return $ret;
    }

    public function getRoom() {
        return $this->getAttr('room');
    }

    public function getTrainerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getClassObj() {
        return Model_Class::getClassObjById($this->getAttr('object_id'));
    }

    public function getHostObj() {
        return Model_User::getUserObjById($this->getAttr('host_id'));
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getOwnerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getLocationObj() {
        return Model_Location::getLocationObjById($this->getAttr('location_id'));
    }

    public function getUserDate() {
        return date('m/d/Y H:i', strtotime($this->getAttr('date')));
    }
}
